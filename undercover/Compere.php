<?php
namespace unit\lrs;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:54
 */
class Compere
{
  private $game;

    /**
     * @param mixed $game
     */
    public function setGame($game)
    {
        $this->game = $game;
    }


    public function nightDies(){
        $ds=[];
        if($this->game->lastWerewolvesKiller!=null&&$this->game->lastWerewolvesKiller->die){
            array_push($ds,$this->game->lastWerewolvesKiller);
        }
        if($this->game->lasttWitchKiller!=null&&$this->game->lasttWitchKiller->die){
            array_push($ds,$this->game->lasttWitchKiller);
        }
        return $ds;
    }

    public function  nightMessage(){
        $ms="昨晚\n";
       $dieCount=0;
        if($this->game->lastWerewolvesKiller!=null ){
            if($this->game->lasttWitchLife!=null){
                //没有人死亡
            }else{
                $player= $this->game->getPlayerByPid($this->game->lastWerewolvesKiller);
                $player->die=true;
                $dieCount++;
                $ms=$ms.$this->game->lastWerewolvesKiller.'死亡\n';
            }
        }

        if($this->game->lasttWitchKiller!=null){
            $player= $this->game->getPlayerByPid($this->game->lasttWitchKiller);
            $player->die=true;
            $dieCount++;
            $ms=$ms.$this->game->lasttWitchKiller.'死亡\n';
        }
        if($this->game->gagSelect!=null){
            $player= $this->game->getPlayerByPid($this->game->gagSelect);
            $ms=$ms.$player->num.'禁言\n';
        }
        if($dieCount<=0){
            $ms=$ms."没有人死亡。";
        }else{
            $ms=$ms."共死亡".$dieCount."人";
        }
        return $ms;
    }

    public function  dayVoteMessage(){
        $ms="投票死亡".$this->game->voteDie->num."号\n";
        return $ms;
    }

    public function forPolice($num){
        foreach ($this->game->players as $p) {
            if($p->num==$num){
                $p->forPolice=true;
            }
        }
    }
    public function beforePolice(){
        foreach ($this->game->players as $p) {
            $p->forPolice=false;
        }
    }


    public function setWerewolvesKill($pid){
        $this->game->lastWerewolvesKiller=$pid;
       // $player->die=true;
    }

    public function setWitchLife($pid){
        $this->game->lasttWitchLife=$pid;
    }
    public function setWitchDie($pid){
        $this->game->lasttWitchKiller=$pid;
        //$this->game->lasttWitchKiller->die=true;
    }

    public function setGagSelect($pid){
        $this->game->gagSelect=$pid;
    }
    public function setPolice ($player){
         $this->game->police=$player;
    }



    public function setVote($player){
        $this->game->voteDie=$player;
        $this->game->voteDie->die=true;
    }


    function __construct($game) {
         $this->game=$game;
    }



    protected   function sortNight($a,$b){
        return($a->getRole()->nightOrder-$b->getRole()->nightOrder);
    }
    public   function day(){
        $this->game->status = Game::STATUS_DAY;
        $this->game->dayNum++;
        $this->game->voteDie=null;
    }

    public   function night(){
        $this->game->nightNum++;
        $this->game->lastOpenEye=-1;
        $this->game->lastWerewolvesKiller=null;
        $this->game->lasttWitchKiller=null;
        $this->game->lasttWitchKiller=null;
        $this->game->gagSelect=null;
    }

    public   function getNightPlayers(){
        $nightPlayers=[];
        foreach ($this->game->players as $p) {
            $no=  $p->getRole()->nightOrder;
            if($no>0){
                array_push($nightPlayers,$p);
            }
        }
        usort($nightPlayers,array("unit\lrs\Compere", "sortNight"));
        return $nightPlayers;
    }

    public   function openEye(){
        $cur=0;
        $curPs=[];
        foreach ($this->getNightPlayers() as $p) {
             if($p->getRole()->nightOrder>$this->game->lastOpenEye&&$cur==0){
                 $this->game->lastOpenEye=$p->getRole()->nightOrder;
                 $cur=$this->game->lastOpenEye;
                 array_push($curPs,$p);
             }else if($p->getRole()->nightOrder==$cur){
                 array_push($curPs,$p);
             }
        }
        return $curPs;
    }
    public   function getLastOpenEye(){
        $curPs=[];
        foreach ($this->getNightPlayers() as $p) {
            if($p->getRole()->nightOrder==$this->game->lastOpenEye){
                array_push($curPs,$p);
            }
        }
        return $curPs;

    }

}