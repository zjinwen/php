<?php
namespace unit\lrs;
require_once 'dao/Db.php';
require_once 'model/GameInfo.php';
require_once 'model/GameModel.php';
require_once 'model/PublicMessage.php';
require_once 'model/PrivateMessage.php';
require_once 'model/Vote.php';
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/2/21
 * Time: 11:12
 */


class GameModel
{

    public    $players;
    public    $playerCount=0;
    public    $speakOrder=0;// -1 1
    public  $globalMs=[];
    public  $globalMsLast=null;

    public  $status;
    public  $statusTimeStart=null;
    public  $statusTimeEnd=null;


    public  $lastOpenEye=0;


    public $lastWerewolvesKiller;
    public $lasttWitchKiller;
    public $lasttWitchLife;
    public $lasttWitchExt;
    public $gagSelect;

    public $hasPolice=false;
    public $police;
    public $voteDie;//白天投票杀死的人
    public $voteType="normal";//投票类型
    public $voteExt=null;//投票类型
    public $nightNum=0;
    public $dayNum=0;

    public $timeoutMessage=200;//单位秒
    public $timeoutVote=20;//单位秒
    public  $voteTimeStart=null;
    public  $voteTimeEnd=null;



    public  $votes=[];
    public  $voteLast=null;

    public  $speaks=[];
    public  $speakLast=null;

    public  $publicMs=[];
    public  $privateMs=[];
    public  $publicLast=null;
    public  $privateLast=null;


    function __construct() {
        Role::initRoles();
        $this->players = [];
        $this->hasPolice=false;

        $this->privateMs=[];
        $this->privateLast=null;

        $this->publicMs=[];
        $this->publicLast=null;


        $this->votes=[];
        $this->voteLast=null;
        $this->speaks=[];
        $this->speakLast=null;


    }


    public function livePlayers($dies){
        $start=$dies[0];
        $ps=[];
        $bps=[];
        if($this->speakOrder>0){
            $f=false;
            foreach ($this->players as $p) {
                if($p->num==$start->num){
                    $f=true;
                }
                if($f&&!$p->die){
                    array_push($ps,$p);
                }else if(!$f&&!$p->die){
                    array_push($bps,$p);
                }
            }
            foreach ($bps as $p) {
                array_push($ps,$p);
            }
            return $ps;
        }else {
            $f=false;
            foreach ($this->players as $p) {
                if($p->num==$start->num){
                    $f=true;
                }
                if($f&&!$p->die){
                    array_push($ps,$p);
                }else if(!$f&&!$p->die){
                    array_push($bps,$p);
                }
            }
            $ns=[];
            $len=count($bps);
            for($i= $len-1; $i>=0; $i--){
                array_push($ns,$bps[$i]);
            }
            $len=count($ps);
            for($i= $len-1; $i>=0; $i--){
                array_push($ns,$ps[$i]);
            }
            return $ns;
        }


    }

    public function  getMessages($playerId,$lastMid,$lastCid,$lastPmid,$controller){
        $ps=[];
        $cu=null;
        foreach ($this->players as $pl){
            $item=array(
                "n"=>$pl->num,
                "nm"=>$pl->name,
                "d"=>$pl->die,
                "p"=> $this->police==$pl->num,
                "r"=>$pl->getRole()->name
            );
            if($playerId==$pl->num){
                $cu=$item;
            }
            array_push($ps,$item);
        }
        $cu['rn']=$controller->gameInfo->name;
        $ms=[];//全局消息
       foreach ($this->globalMs as $m) {
           if($m->mid>$lastMid){
               $m->confirm($playerId,$m->mid);
               array_push($ms,$m);
           }
       }
       //test get last one
        /*if(count($ms)>0){
            $ms=array($ms[count($ms)-1]);
        }*/
        $chatMessages=[];//发言消息
        /*if($this->chat->groupLast!=null&&!$this->chat->groupLast->isVote) {//聊天
            foreach ($this->chat->groupLast->messages as $m) {
                if($m->time>$lastCid){
                    array_push($chatMessages,$m);
                }
            }
        }*/
        /*if(count($chatMessages)>0){
            $chatMessages=array($chatMessages[count($chatMessages)-1]);
        }*/

        $v=null;
        $group=false;
        if($this->chat->groupLast!=null&&$this->chat->groupLast->isVote){//投票
            $vs=[];
            $vbs=[];
            $uin=in_array($playerId, $this->chat->groupLast->playerIds);
            if($uin){
                foreach ($this->chat->groupLast->playerIds as $m) {
                    array_push($vs,$m);
                }
                $group=true;
                $vbs=$this->chat->groupLast->vbs;
            }
            $hasVote=$this->chat->groupLast->isPlayerSelected($playerId);

            $v=array("vs"=>$vs,"ve"=>$this->voteExt,"vbs"=>$vbs,"has"=>$hasVote,"vt"=>$this->voteType);
        }

        if($this->chat->groupLast!=null&&!$this->chat->groupLast->isVote){//聊天
            $vs=[];
            foreach ($this->chat->groupLast->playerIds as $m) {
                array_push($vs,$m);
            }
            if(in_array($playerId, $this->chat->groupLast->playerIds)){
                $group=true;
            }
            $hasVote=$this->chat->groupLast->isPlayerSpeak($playerId);
            $currentSpeakId=$this->chat->groupLast->currentSpeacherId;
            $gap=-1;
            if($this->gagSelect!=null){
                $gap=$this->gagSelect->num;
            }

            $v=array("vs"=>$vs,"vbs"=>$this->chat->groupLast->vbs,"has"=>$hasVote,"vt"=>$this->voteType,"spk"=>$currentSpeakId,
                "gaps"=>array($gap));
        }


        $rs= array("ms"=>$ms,"cs"=>$chatMessages,"ps"=>$ps,"v"=>$v,"code"=>0,"g"=>$group,
            "pms"=>PrivateMessageManager::getUserPrivateMessage($this,$playerId,$lastPmid));
        if($lastMid<=0){
            $rs["u"]=$cu;
        }

        //设置状态
        $this->setGameStatus($controller,$playerId);
       return $rs;
    }

    /**
     * 设置状态
     */
    private function  setGameStatus($controller,$playerId){
        $timeSpeak=60*60*24*10;
        $timeVote=60*60*24*10;
        $timeConfirm=60*60*24*10;
        if($this->status==GAME::GAME_STATUS_FULL){
            if(!$this->messageConfirm()){
                return ;
            }else{
                $this->status=GAME::STATUS_NIGHT;
                $controller->compere->night();
                return ;
            }
        }else if($this->status==GAME::STATUS_NIGHT){
            if(!$this->messageConfirm()){
                return ;
            }
            if(!$this->voteConfirm()){
                return ;
            }
            $nps = $controller->compere->openEye();
            if (count($nps) > 0) {
                $message= $nps[0]->getRole()->name. "请睁眼,".($nps[0]->getRole()->nightMessage)."\n";//睁眼消息 ，开始投票

                $ps=$this->getPlayerIdsNotInNotDie($nps);
                foreach ($nps as $p){
                    if($p->getRole()->nightVoteSelf){
                        array_push($ps,$p->num);
                    }
                }
                $this->clientMessage($message,$timeConfirm);
                $this->clientVote("投票",$timeVote,$nps,$ps);
                if($nps[0]->getRole()->name=='女巫'){
                    $this->voteType="witch";
                    $this->lasttWitchExt->lastPid=$this->lastWerewolvesKiller;
                    $this->voteExt=$this->lasttWitchExt;
                }else if($nps[0]->getRole()->name=='预言家'){
                    $this->voteType="tell";
                }else if($nps[0]->getRole()->name=='狼人'){
                    $this->voteType="wolve";
                }else if($nps[0]->getRole()->name=='禁言长老'){
                    $this->voteType="gag";
                }

            }else{//全部结束
                $message="天亮请睁眼;";

                if(!$this->hasPolice){
                    $message=$message."竞选警长.";
                    $this->clientMessage($message,$timeConfirm);
                    $this->clientVote("投票",$timeVote,$this->players,[]);
                    $this->voteType="jz";
                    $controller->compere->beforePolice();
                    $this->status=GAME::STATUS_DAY_POLICE;

                }else{
                    $this->clientMessage("昨晚消息".$controller->compere->nightMessage(),$timeConfirm);
                    $this->clientMessage("白天发言",$timeConfirm);
                    if($this->police!=null){
                        $this->clientMessage("警长选择发言顺序",$timeConfirm);
                        $this->speakOrder=0;

                        $this->clientVote("投票",$timeVote,array($this->police),array($this->police->num));
                        $this->voteType="chatOrder";
                        $this->status=GAME::STATUS_DAY_SPEAK_ORDER;
                    }else{
                        $this->status=GAME::STATUS_DAY;
                    }
                }
            }
        }else if($this->status==GAME::STATUS_DAY_POLICE){
            if(!$this->messageConfirm()){
                return ;
            }
            if($this->isAllSelected()){//参选警长
                $cps=[];
                foreach ( $this->chat->groupLast->messages as $m){
                    if($m->message==$m->playerId){
                        array_push($cps,$m->playerId);
                    }
                }
                if(count($cps)==0){//没有人竞选警长,随机选择一个
                    $cps=array_push($cps,$this->players[rand(0,count($this->players)-1)]);
                }

                $this->clientMessage("竞选警长发言",$timeConfirm);
                $this->clientChat($this->getPlayers($cps));
                $this->status=GAME::STATUS_DAY_POLICE_SPEAK;
            }
        }else if($this->status==GAME::STATUS_DAY_POLICE_SPEAK){
            if(!$this->messageConfirm()){
                return ;
            }
            if($this->isAllSpeak()){//投票

                //获取发言警长后选人

                $policeIds= $this->chat->groupLast->playerIds;
                $vIds=$this->getPlayersNotIn( $policeIds);
                if(count($vIds)==0){//没有人投票
                    foreach ($this->players as $p) {
                            array_push($vIds,$p->num);
                    }
                }
                $this->clientMessage("竞选警长投票",$timeConfirm);
                $this->clientVote("投票",$timeVote,$vIds,$policeIds);
                $this->status=GAME::STATUS_DAY_POLICE_VOTE;
            }

        }else if($this->status==GAME::STATUS_DAY_POLICE_VOTE){
            if(!$this->messageConfirm()){
                return ;
            }
            if($this->isAllSelected()){
                $selectPlayer = $this->getMaxSelectPlayer();
                $controller->compere->setPolice($selectPlayer);
                $this->clientMessage("昨晚消息".$controller->compere->nightMessage(),$timeConfirm);
                $this->clientMessage("白天发言",$timeConfirm);
                if($this->police!=null){
                    $this->clientMessage("警长选择发言顺序",$timeConfirm);
                    $this->speakOrder=0;

                    $this->clientVote("投票",$timeVote,array($this->police),array($this->police->num));
                    $this->voteType="chatOrder";
                    $this->status=GAME::STATUS_DAY_SPEAK_ORDER;
                }
            }

        }else if($this->status==GAME::STATUS_DAY_SPEAK_ORDER){
            if(!$this->messageConfirm()){
                return ;
            }
            if(!$this->hasSelectSpeakOrder()){
                return ;
            }

            $this->status=GAME::STATUS_DAY;

        }else if($this->status==GAME::STATUS_DAY){
            if(!$this->messageConfirm()){
                return ;
            }
            $pids=$this->getPlayerIdsNotInNotDie([]);
            $lpids=[];
            foreach ($pids as $pid) {
                 if($pid!=$this->gagSelect->num){
                     array_push($lpids,$pid);
                 }
            }

            //开始发言
            $message="开始发言";
            if($this->speakOrder>0){
                $message=$message."死亡右边开始";
            }else{
                $message=$message."死亡左边开始";
            }
            $this->clientMessage($message,$timeConfirm);
            $this->clientChat($this->getPlayers($lpids));

            $this->status=GAME::STATUS_DAY_SPEAK;

        }else if($this->status==GAME::STATUS_DAY_SPEAK){
            if(!$this->messageConfirm()){
                return ;
            }
            if($this->isAllSpeak()){//投票

                $policeIds= $this->chat->groupLast->playerIds;
                $vIds=$policeIds;
                if(count($vIds)==0){//没有人投票
                    foreach ($this->players as $p) {
                        array_push($vIds,$p->num);
                    }
                }
                $this->clientMessage("白天投票",$timeConfirm);
                $this->clientVote("投票",$timeVote,$vIds,$policeIds);
                $this->status=GAME::STATUS_DAY_VOTE;
            }


        }else if($this->status==GAME::STATUS_DAY_VOTE){
            if(!$this->messageConfirm()){
                return ;
            }
            if($this->isAllSelected()){
                $selectPlayerId = $this->getMaxSelectPlayer();
                $this->clientMessage("白天死亡".$selectPlayerId."号",$timeConfirm);
                $this->clientMessage("天黑请闭眼！",$timeConfirm);
                $controller->compere->night();
                $this->status=GAME::STATUS_NIGHT;
            }


        }
    }

    public function setSpeakOrder($pid,$order){
        if($this->police!=$pid)return false;
         $this->speakOrder=$order;
         return true;
    }

    private function hasSelectSpeakOrder(){
         return $this->speakOrder!=0;
    }
    private function lastWordsPlayers(){

        return ;
    }

    private function getPlayerIdsNotInNotDie($players){
        $ps=[];
        $pids=[];
        foreach ($players as $p){
             array_push($pids,$p->num);
        }
        foreach ($this->players as $p){
            if(!in_array($p->num,$pids)&&!$p->die){
                array_push($ps,$p->num);
            }
        }
        return $ps;
    }

    private function getPlayersNotIn($pids){
          $ps=[];
          foreach ($this->players as $p){
             if(!in_array($p->num,$pids)){
                 array_push($ps,$p);
             }
        }
        return $ps;
    }

  private function getMaxSelectPlayer(){
      return $this->chat->groupLast->getMaxSelect($this);
  }

    private function isAllSelected(){
          return $this->chat->groupLast->isAllSelected($this);
    }

    private function  voteConfirm(){
         if($this->chat->groupLast==null){
            return true;
         }
         if($this->chat->groupLast->isAllSelected($this)){
             return true;
         }
        if($this->isVoteWait()){
            return false;
        }
        return true;
    }

 private function  messageConfirm(){
      if($this->globalMsLast==null){
            return true;
      }

     if($this->globalMsLast->isAllConfirm()){
         return true;
     }
     if($this->isStatusWait()){
         return false;
     }
      $this->globalMsLast->confirmAll();
     return true;
 }

    public function forPolices($f){
        $ps=[];
        foreach ($this->players as $p) {
            if($p->forPolice==$f){
                array_push($ps,$p);
            }
        }
        return $ps;
    }

    /**
     * @param $nickName
     * @return bool
     */
    public function addPlayer($nickName,$photo="",$pid=""){
            //判断是否已经加入
           $timeConfirm=60*60*24*10;
           if($pid!=""){
               foreach ($this->players as $sr) {
                   if($sr->num==$pid){
                       if($sr->name==null){
                          $sr->name=$nickName;
                       }
                       $sr->photo=$photo;
                       $all=true;
                       foreach ($this->players as $sr2) {
                           if($sr2->name==null){
                               $all=false;
                               break;
                           }
                       }
                       if($all){
                           if($this->status==GAME::GAME_STATUS_FREE){
                              $this->status=GAME::GAME_STATUS_FULL;
                               $this->clientMessage("游戏开始,天黑请闭眼！",$timeConfirm);
                           }
                       }

                       return $sr;
                   }
               }
           }
              $freePlayer=[];
              foreach ($this->players as $sr) {
                  if($sr->name==null){
                      array_push($freePlayer,$sr);
                  }
              }
              $freeRoleCount=count($freePlayer);
              if($freeRoleCount<=0){
                  return null;//全部加好
              }

               $freeRand=rand(0,$freeRoleCount-1);
               $sel=$freePlayer[$freeRand];
               $sel->name=$nickName;
               $sel->photo=$photo;

              if($freeRoleCount==1 &&$this->status==GAME::GAME_STATUS_FREE){
                  $this->status=GAME::GAME_STATUS_FULL;
                  $this->clientMessage("游戏开始,天黑请闭眼！",$timeConfirm);

              }
              return $sel;
    }
    public function isStatusWait(){
        $bf= $this->statusTimeEnd>time();
          if($bf){
              //echo "等等".( $this->statusTimeEnd-time())."\n";
              return true;
        }
         return false;
    }
    public function isVoteWait(){
            $bf= $this->voteTimeEnd>time();
            if($bf){
                //echo "等等".( $this->statusTimeEnd-time())."\n";
                return true;
            }
            return false;
    }
    private function pushMessage($message,$players,$autoConfirm){
        $mid=1;
        if(count($this->globalMs)!=0){
            $mid=$this->globalMs[count($this->globalMs)-1]->mid+1;
        };
         $gm=new GlobalMessage($autoConfirm);
         $gm->time=time();
         $gm->setAutoConfirm($autoConfirm);
         $gm->waitForConfirm($players,$message,$mid);
         $this->globalMsLast=$gm;
         array_push($this->globalMs,$gm);
    }




    public function  getChatPlayers(){
        return $this->getPlayers($this->chat->groupLast->playerIds);
    }
    public function  isAllSpeak(){
        return $this->chat->groupLast->isAllSpeak();
    }
    public function  addChatMessage($messageTxt,$pid){//投入全局消息

        $rs=  $this->chat->groupLast->addMessage($this,$messageTxt,$pid );
        if($rs){
            $timeConfirm=60*60*24*10;
            $message=">".$pid."号:".$messageTxt;
            $this->clientMessage($message,$timeConfirm);
        }
        return true;
    }
    public function  setChatCurrentSpeaker($spNum){
        $this->chat->groupLast->currentSpeacherId=$spNum;
    }
    public function  getPlayers($playerIds){
        $ps=[];
        foreach ($this->players as $sr) {
            if(in_array($sr->num, $playerIds)){
                array_push($ps,$sr);
            }
        }
        return $ps;
    }
    public function  getPlayerByPid($pid){
        return $this->getPlayerByNum($pid);
    }

    public function getPlayerByNum($num){
        foreach ($this->players as $pl) {
              if($pl->num==$num){
                  return $pl;
              }
        }
        return null;
    }
    public function setSelectRoles($map)
    {
     //   var_dump( $map);
        $curNum=1;
        foreach ($map as $key => $value) {
            $found=null;
            foreach (Role::$roles as $sr) {
                if($sr->name==$key){
                    if($value>$sr->max){
                        return $sr->name."超出最大数限制";
                    }
                    $found=$sr;
                    break;
                }
            }
            if($found!=null){
                for($i=0;$i<$value;$i++){
                    $player=new  Player(null,$curNum++,$found->roleId,"xx.png");
                    array_push($this->players,$player);
                }
            }
        }
        $this->playerCount= count($this->players);
    }

    public function setSelectRolesByRoleId($map)
    {
        $curNum=1;
        foreach ($map as $obj) {
            $found=null;
            foreach (Role::$roles as $sr) {
                if($sr->roleId==$obj->roleId){
                    if($obj->roleIdNum>$sr->max){
                        return $sr->name."超出最大数限制";
                    }
                    $found=$sr;
                    break;
                }
            }
            if($found!=null){
                for($i=0;$i<$obj->roleIdNum;$i++){
                    $player=new  Player(null,$curNum++,$found->roleId,"xx.png");
                    array_push($this->players,$player);
                }
            }
        }
        $this->playerCount= count($this->players);
    }
        public function tellSelect($tid,$playerId,$controller){
            $tp= $this->getPlayerByNum($tid);
            $this->select($tid,$playerId,$controller);
            return $tp->getTellMessage();
        }
    public function witchSelect($witchOp,$wid,$playerId,$controller){
        $witch = $this->lasttWitchExt;
        if($witchOp=='antidote'&&!$witch->lifeUse&&$this->lastWerewolvesKiller==$wid){
            $witch->curUse = 'antidote';
            $witch->lifeUse = true;
        }else if($witchOp=='poison'&&!$witch->killUse){
            $witch->curUse = 'antidote';
            $witch->killUse = true;
        }else {
            $witch->curUse = 'none';
        }
       return  $this->select($wid,$playerId,$controller);
    }
    public function select($num,$playerId,$controller){
        $rs= $this->chat->groupLast->select($this,$num, $playerId);
       if($this->chat->groupLast->isAllSelected($this)){
           $playerSelect= $this->getPlayerByNum($this->chat->groupLast->getMaxSelect($this));
           if($playerSelect!=null){
               $this->selectPlayerProcess($playerId,$playerSelect,$controller);
           }
       }
        return $rs;
    }
    private function  selectPlayerProcess($playerId,$playerSelect,$controller){
        $player= $this->getPlayerByNum($playerId);
        if ($player->getName() == '预言家') {
            $player->setTellerExt($playerSelect);// 选择最大一个
            PrivateMessageManager::addMessage($this,array($playerId),$playerSelect->getTellMessage());
        }
        if ($player->getName() == '狼人') {
            $dieByWk = $playerSelect;
            $controller->compere->setWerewolvesKill($dieByWk->num);
        }
        if ($player->getName() == '女巫') {
            $witch = $this->lasttWitchExt;
            //test
            //
            if ($witch->curUse != null) {
                if ($witch->curUse == 'poison') {
                    $dieByWk = $playerSelect;
                    $controller->compere->setWitchDie($dieByWk->num);
                } else if ($witch->curUse == 'antidote') {
                    $controller->compere->setWitchLife($playerSelect->num);
                }
            }
        }
        if ($player->getName() == '禁言长老') {
            $selectGap = $playerSelect;
            $controller->compere->setGagSelect($selectGap);
        }

    }
 /*public function  testPolice($controller){

     $timeConfirm=60*60*24*10;
     $timeVote=60*60*24*10;
     $message="竞选警长.";
     $this->clientMessage($message,$timeConfirm);
     $this->clientVote("投票",$timeVote,$this->players,[]);
     $this->voteType="jz";
     $controller->compere->beforePolice();
     $this->status=GAME::STATUS_DAY_POLICE;

 }*/
    public function  setStatus($controller,$status){
        $this->status=$status;

    }

    private function clientMessage($message,$timeConfirm)
    {
        $this->statusTimeStart = time();
        $this->statusTimeEnd = $this->statusTimeStart + $timeConfirm;
        $this->pushMessage($message, $this->players, true);
    }

     private function clientVote($message,$timeVote,$players,$vbs=null)
    {
            $this->voteType="normal";
            $this->voteTimeStart = time();
            $this->voteTimeEnd = $this->voteTimeStart + $timeVote;
            $this->chat->addGroup($players, true,$vbs);
    }

    private function clientChat($players)
    {
        $this->voteType="chat";
        $this->chat->addGroup($players, false);
        $ps = $this->getChatPlayers();
        $this->setChatCurrentSpeaker($ps[0]->num);
    }
}