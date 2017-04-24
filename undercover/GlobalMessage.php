<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


class GlobalMessage
{
    public  $mid;
    public  $message;
    public  $time;
    private $autoConfirm;
    private $waitConfirm=[];
    private $waitStatus=false;

    /**
     * @param mixed $autoConfirm
     */
    public function setAutoConfirm($autoConfirm)
    {
        $this->autoConfirm = $autoConfirm;
    }



    public function isWaitStatus(){
        return $this->waitStatus;
    }
    public function confirm($playerId,$mid)
    {
        if($mid!=$this->mid)return false;

        foreach ($this->waitConfirm as $obj) {
            if($obj->num==$playerId){
                $obj->cm=true;
            };
        }
        $this->isAllConfirm();
        return true;
    }
    public function confirmAll()
    {
        foreach ($this->waitConfirm as $obj) {
            $obj->cm=true;
        }
        $this->waitStatus=false;
        return true;
    }
    public function isAllConfirm()
    {
        foreach ($this->waitConfirm as $obj) {
            if($obj->cm!=true){
                return false;
            };
        }
        $this->waitStatus=false;
        return true;
    }
    public function waitForConfirm($players,$message,$mid){
        $this->waitStatus=true;
        $this->message=$message;
        $this->mid=$mid;
        $this->waitConfirm=[];
        foreach ($players as $sr) {
            $obj=(Object)[];
            $obj->num=$sr->num;
            $obj->cm=false;
            array_push($this->waitConfirm,$obj);
        }
    }



}