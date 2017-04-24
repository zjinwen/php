<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


class Chat
{
    public  $id;
    public  $groups;
    public  $groupLast;
    public  $time;


    function __construct() {
        $this->groups = [];
        $this->time = time();
    }
    public function addGroup($players,$isVote,$vbs=null){
        $ps=[];
        foreach ($players as $p) {
            array_push($ps,$p->num);
        }

           $group=new Group($ps,$this);
           $group->isVote=$isVote;
           $this->groupLast=$group;

           if($vbs!=null){
               $group->vbs=$vbs;
           }
           array_push($this->groups,$group);
    }

}