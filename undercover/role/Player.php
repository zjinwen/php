<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


class Player
{
    public  $name="";//昵称
    public  $photo="";//头像
    public  $num=0;//序号
    public  $die=false;
    public  $forPolice=false;

    public $roleId;

    function __construct($name="",$num=1,$roleId,$photo="") {
        $this->name = $name;
        $this->num = $num;
        $this->roleId = $roleId;
        $this->photo = $photo;
        $this->die=false;
    }

    public $ext=[];
    public function setTellerExt($palyer){
        array_push($this->ext,$palyer->num."号_".($palyer->getRole()->isGood?"好人":"坏人"));
        //array_push($this->ext,$palyer->num."号_".($palyer->getRole()->name));
    }
    public function getRole(){
        foreach (Role::$roles as $role) {
            if($role->roleId==$this->roleId){
                return $role;
            }
        }
    }
    public function getName(){
       return $this->getRole()->name;
    }

    public function getTellMessage(){
      return $this->num."号_".($this->getRole()->isGood?"好人":"坏人");
    }
}