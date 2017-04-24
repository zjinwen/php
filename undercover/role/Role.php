<?php
namespace unit\lrs;
require_once 'role/GagRole.php';
require_once 'role/HunterRole.php';
require_once 'role/PopulaceRole.php';
require_once 'role/RFun.php';
require_once 'role/SeerRole.php';
require_once 'role/WitchRole.php';
require_once 'role/WolfRole.php';


/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/2/21
 * Time: 10:45
 */
class Role
{
    public  $name="";
    public  $nightOrder=1;//0不可以睁眼 其他可以睁眼
    public  $viewOrder=1;
    public  $photo="";
    public $max=4;
    public $min=0;
    public $isGood=true;
    public $initSize=1;
    public $nightMessage="";
    public $nightVoteSelf=false;
    public $rf;

    /**
     * @param mixed $rf
     */
    public function setRf($rf)
    {
        $this->rf = $rf;
        return $this;
    }


    public static  $roles=null;

    public  static function initRoles() {
        Role::$roles = [
            (new Role(1,'普通村民',0,1,'',10,1))->setIsGood(true)->initSize(3)->setNightMessage("")->setRf(new PopulaceRole()),
            (new Role(2,"狼人",2,1,"",10,1))->setIsGood(false)->initSize(3)->setNightMessage("请选择今晚要杀死的玩家")->setRf(new WolfRole()),
            (new Role(3,"猎人",0,1,"",1,0))->setIsGood(true)->initSize(1)->setNightMessage("")->setRf(new HunterRole()),
            (new Role(4,"预言家",1,1,"",1,0))->setIsGood(true)->initSize(1)->setNightMessage("请选择今晚要验的玩家")->setRf(new SeerRole()),
            (new Role(5,"女巫",3,1,"",1,0))->setIsGood(true)->initSize(1)->setNightMessage("请选择今晚要使用药物的玩家")->setNightVoteSelf(true)->setRf(new WitchRole()),
            (new Role(6,"禁言长老",4,1,"",1,0))->setIsGood(true)->initSize(1)->setNightMessage("请选择今晚要禁言的玩家")->setRf(new GagRole())];
    }




    public  $roleId=0;


    public function setNightVoteSelf($nightVoteSelf)
    {
        $this->nightVoteSelf = $nightVoteSelf;
        return $this;
    }

    public function setIsGood($isGood){
        $this->isGood=$isGood;
        return $this;
    }

    public function initSize($initSize){
        $this->initSize=$initSize;
        return $this;
    }

    public function setNightMessage($nightMessage)
    {
        $this->nightMessage = $nightMessage;
        return $this;
    }



    function __construct($roleId,$name="",$nightOrder=1,$viewOrder=1,$photo=""
        ,$max=4,$min=0
    ) {
        $this->roleId = $roleId;
        $this->name = $name;
        $this->nightOrder = $nightOrder;
        $this->viewOrder = $viewOrder;
        $this->photo = $photo;
        $this->min = $min;
        $this->max = $max;

    }

    function  getHtml(){
        return "<div>".$this->name."</div>";
    }




}