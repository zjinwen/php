<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


class Group
{
    public  $id;
    public  $playerIds;
    public  $vbs;//被投票人
    public  $overIds;
    public  $messages;
    public  $isVote;
    public  $currentSpeacherId; //当前发言的人
    public  $lastTime;//最后操作时间
    public  $mid;

    function __construct($playerIds) {
        $this->playerIds = $playerIds;
        $this->messages = [];
        $this->overIds = [];
    }
    public function  isAllSpeak(){
        foreach ($this->playerIds as $pid) {
            if(!in_array ($pid,$this->overIds)){
                return false;
            }
        }
        return true;
    }
    public function  isPlayerSpeak($playerId){
      return  in_array ($playerId,$this->overIds);
    }
    public function  getMaxSelect($game){
        $ms=[];
        foreach ($this->messages as $m) {
            if((int)$m->message==-1)continue;
                $f=false;
                foreach ($ms as $s) {

                    if($s->num==(int)$m->message){
                        $s->value++;
                        $f=true;
                    }
                }
                if(!$f){
                    $obj=(object)[];
                    $obj->num=(int)$m->message;
                    $obj->value=1;
                    array_push($ms,$obj);
                }
        }
        $same=false;
        $selMax=-1;
        $selNum=null;
        foreach ($ms as $s) {
           if($selMax<$s->value){
               $selMax=$s->value;
               $selNum=$s->num;
               $same=false;
           }else if($selMax!=-1&&$selMax==$s->value){
               $same=true;
           }
        }
        $sameNums=[];
        if($same){
            foreach ($ms as $s) {
                if($selMax==$s->value){
                    array_push($sameNums,$s->num);
                }
            }
            return $sameNums[rand(0,count($sameNums)-1)]  ;
        }else if($selNum!=null){
            return $selNum;
        }else{//全部没有选择
            $ls=[];
            foreach ($game->getPlayers($this->playerIds) as $p) {
                if(!$p->die){
                    array_push($ls,$p->num);
                }
            }
            if(!empty($ls)){
               return $ls[rand(0,count($ls)-1)]  ;
            }
        }
    }
    public function  isPlayerSelected($pid){
        if(!$this->isVote)return "error";
        foreach ($this->messages as $m) {
            if($pid==$m->playerId){
                return true;
            }
        }
        return false;
    }

    public function  isAllSelected($game){
        if(!$this->isVote)return "error";

        foreach ($game->getPlayers($this->playerIds) as $p) {
            $p->_select=false;
        }

        foreach ($this->messages as $m) {
                foreach ($game->getPlayers($this->playerIds) as $p) {
                    if($p->num==$m->playerId){
                        $p->_select=true;
                    }
                }
        }
        foreach ($game->getPlayers($this->playerIds) as $p) {
            if(!$p->_select){
                return false;
            };
        }
        return true;
    }
    public function addMessage($game,$message,$pid){
       if($this->isVote)return false;
       if($this->currentSpeacherId!=$pid){
           return false;
       }
        if(in_array ($pid,$this->overIds)){
            if($this->currentSpeacherId==$pid){
                $this->nextSpeakId();
            }
            return false;
        }
       if($message==""){
             array_push($this->overIds,$pid);
             $this->nextSpeakId();
       }
        $mg=new Message($pid,$message);
        array_push($this->messages,$mg);
        if($message==""){
            return false;
        }
        return true;
    }
    public function nextSpeakId(){
        foreach ($this->playerIds as $pid) {
            if(!in_array ($pid,$this->overIds)){
                $this->currentSpeacherId=$pid;
                break;
            }
        }
    }
    public function select($game,$num,$playerId){
        if(!$this->isVote)return false;
        $f=false;
        foreach ($this->messages as $p) {
            if($p==$playerId){
                return false;
            }
        }
        foreach ($this->playerIds as $p) {
            if($p==$playerId){
                $f=true;
                break;
            }
        }
        if($f){
            $mg=new Message($playerId, $num);
            array_push($this->messages,$mg);
        }
        return $f;
    }


}