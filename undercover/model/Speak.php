<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


class Speak
{
    public  $pids;
    public  $has;
    public  $bpids;
    public  $time;
    public $index=0;

   public function __construct($pids,$bpids) {
       $this->pids = $pids;
       $this->bpids = $bpids;
       $this->time = time();
       $this->has = [];
       $this->index = 0;

   }
    public function current(){
       if($this->index==-1){
           return null;
       }
        return $this->pids[$this->index];
    }
    public function next(){
        if($this->index<count($this->pids)){
            $this->index++;
        }else{
            $this->index=-1;
        }
        return $this->currentSpeaker();

    }


}