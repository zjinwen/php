<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;
error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once 'Game.php';
require_once 'CompereManager.php';
require_once 'Chat.php';
require_once 'Group.php';
require_once 'Message.php';
require_once 'GameInfo.php';
require_once 'Db.php';
require_once 'GUtils.php';

use unit\lrs\Game;
use unit\lrs\Compere;
use unit\lrs\Chat;
use unit\lrs\Group;
use unit\lrs\Message;
use unit\lrs\GameInfo;
use unit\lrs\Role;
use unit\lrs\Db;
use unit\lrs\GUtils;

class GameController
{
    public  $game;
    public  $gameInfo;
    public  $compere;
    function __construct() {
        $this->game = new Game();
        $this->gameInfo = new GameInfo();
        $this->compere = new Compere($this->game);
    }

    public function getErrorMessage($message){
        return  array("code"=>1,"message"=>$message);
    }

    public function successMessage($message){
        return  array("code"=>0,"message"=>$message);
    }
    public function  process($cmd){
        $roomNum =null;
        if(isset($_REQUEST['roomNum'])){
            $roomNum =$_REQUEST["roomNum"];
        }
         if( !is_null($roomNum)&&$cmd!='create'){
            if(!$this->isRoomExist($roomNum)) {
                return $this->getErrorMessage($roomNum."房间号不存在");
            }
         }

            switch ($cmd){
                case "create":
                    $roomNum=$this->createRoom();
                    $this->createRoomRoles();
                    $this->save();
                   // $this->setCookie("roomNum",$roomNum);
                    return $this->successMessage($roomNum);
                    break;
                case "enter":
                    if(is_null($roomNum)||is_null($_REQUEST["nickName"])){
                        return $this->getErrorMessage("请填写 roomNum nickName");
                    }
                    $this->load($roomNum);
                    $pid="";
                    if(isset($_REQUEST['pid'])){
                        $pid=$_REQUEST['pid'];
                    }
                    $sel=$this->game->addPlayer($_REQUEST["nickName"],"",$pid);
                    if($sel!=null){
                        $this->save();
                       // $this->setCookie("pid",$sel->num);
                       // $this->setCookie("roomNum",$roomNum);
                        return $this->successMessage($sel->num);
                    }else{
                        return $this->getErrorMessage("进入房间失败");
                    }
                    break;
                case "message"://客户端 订阅请求
                    if($roomNum==null||!isset($_REQUEST["pid"])){
                        return $this->getErrorMessage($roomNum."请重新进入房间");
                    }
                    $this->load($roomNum);
                    $playerId=$_REQUEST["pid"];
                    $lastMid=-1;
                    $lastCid=-1;
                    $lastPmid=-1;
                    if(isset($_REQUEST['lastMid'])){
                        $lastMid=$_REQUEST["lastMid"];
                    }
                    if(isset($_REQUEST['lastCid'])){
                        $lastCid=$_REQUEST["lastCid"];
                    }
                    if(isset($_REQUEST['lastPmid'])){
                        $lastPmid=$_REQUEST["lastPmid"];
                    }
                    $json= $this->game->getMessages($playerId,$lastMid,$lastCid,$lastPmid,$this);
                    $this->save();
                    return $json;
                    break;
                case "confirm"://客户端收到消息
                    /*$this->load($roomNum);
                    $playerId=$_REQUEST["pid"];
                    $this->game->confirm($playerId);
                    $this->save();*/
                    break;
                case "gag":

                    $voteId=-1;
                    if(isset($_REQUEST['tid'])){
                        $voteId =$_REQUEST["tid"];
                    }
                    if($voteId==-1){
                        return $this->getErrorMessage($roomNum."请选择禁言的人");
                    }
                    $playerId=$_REQUEST["pid"];
                    $this->load($roomNum);
                    $rs=$this->game->select($voteId,$playerId,$this);
                    $this->save();
                    if(!$rs){
                        return $this->getErrorMessage("禁言失败");
                    }else{
                        return $this->successMessage("禁言成功");
                    }
                    break;
                case "vote":

                    $voteId=-1;
                    if(isset($_REQUEST['vid'])){
                        $voteId =$_REQUEST["vid"];
                    }
                    if($voteId==-1){
                        return $this->getErrorMessage($roomNum."请选择投票人");
                    }
                    $playerId=$_REQUEST["pid"];
                    $this->load($roomNum);
                    $rs=$this->game->select($voteId,$playerId,$this);
                    $this->save();
                    if(!$rs){
                        return $this->getErrorMessage("投票失败");
                    }else{
                        return $this->successMessage("投票成功");
                    }
                    break;
                case "chat":
                    $mess="";
                    if(isset($_REQUEST['mess'])){
                        $mess =$_REQUEST["mess"];
                    }
                    $playerId=$_REQUEST["pid"];

                    $this->load($roomNum);
                    $rs=$this->game->addChatMessage($mess,$playerId);
                    $this->save();
                    if(!$rs){
                        return $this->getErrorMessage("结束发言");
                    }else{
                        return $this->successMessage("发言成功");
                    }
                    break;

                case "tell":
                    $playerId=$_REQUEST["pid"];
                    $tid=$_REQUEST["tid"];
                    $this->load($roomNum);
                    $rs=$this->game->tellSelect($tid,$playerId,$this);
                    $this->save();
                    return $this->successMessage($rs);
                    break;
                case "wolve":
                    $voteId=-1;
                    if(isset($_REQUEST['vid'])){
                        $voteId =$_REQUEST["vid"];
                    }
                    if($voteId==-1){
                        return $this->getErrorMessage($roomNum."请选择要杀害的人");
                    }
                    $playerId=$_REQUEST["pid"];
                    $this->load($roomNum);
                    $rs=$this->game->select($voteId,$playerId,$this);
                    $this->save();
                    if(!$rs){
                        return $this->getErrorMessage("投票失败");
                    }else{
                        return $this->successMessage("投票成功");
                    }
                    break;
                case "witch":
                $witchOp="";
                if(isset($_REQUEST['witchOp'])){
                    $witchOp =$_REQUEST["witchOp"];
                }
                 $playerId=$_REQUEST["pid"];
                 $wid=$_REQUEST["wid"];
                 $this->load($roomNum);
                 $rs=$this->game->witchSelect($witchOp,$wid,$playerId,$this);
                $this->save();
                if(!$rs){
                    return $this->getErrorMessage("操作失败");
                }else{
                    return $this->successMessage("操作成功");
                }
                break;
                case "chatOrder":
                    $order=1;
                    if(isset($_REQUEST['order'])){
                        $order =$_REQUEST["order"];
                    }
                    $playerId=$_REQUEST["pid"];
                    $this->load($roomNum);
                    $rs=$this->game->setSpeakOrder($playerId,$order);
                    $this->save();
                    if(!$rs){
                        return $this->getErrorMessage("设置失败");
                    }else{
                        return $this->successMessage("设置成功");
                    }
                    break;
                case "exit":
                    $this->delCookie("pid");
                    $this->delCookie("roomNum");
                    $this->delCookie("lastMid");
                    $url = "go.php";
                    header( "Location: $url" );
                   // return $this->successMessage("");
                    break;

                case "testInfo":
                    if($roomNum==null){
                        return $this->getErrorMessage("请重新进入房间");
                    }
                    $this->load($roomNum);
                    $ps=[];
                    foreach ($this->game->players as $pl){
                        $item=array(
                            "n"=>$pl->num,
                            "nm"=>$pl->name,
                            "d"=>$pl->die,
                            "r"=>$pl->getRole()->name
                        );
                        array_push($ps,$item);
                    }

                    $rs= array("ps"=>$ps,"code"=>0);
                   // $this->save();
                    return $rs;
                    break;
                case "setStatus":
                    if($roomNum==null){
                        return $this->getErrorMessage("请重新进入房间");
                    }
                    $this->load($roomNum);
                    $this->game->setStatus($this,7);
                    $this->save();
                    return $this->successMessage("成功");
                    break;
                default: return $this->getErrorMessage("不可用命令");
            }

    }
    public function  delCookie($cookieName){
        SetCookie($cookieName, "", time()-3600, "/");
    }
    public function  setCookie($cookieName,$value){
        SetCookie($cookieName, $value, time()+3600*24*7, "/");
    }
    public function  getStatusJson(){

    }

    public function createRoomRoles(){
        $roleStr = $_REQUEST["roles"];
        $roles=explode(";", $roleStr);
        $map=[];

        foreach ($roles as $rs) {
            $is=explode("_", $rs);
            $roleId=$is[0];
            $roleIdNum=$is[1];
            $obj=(object)[];
            $obj->roleId=$roleId;
            $obj->roleIdNum=$roleIdNum;
            array_push($map,$obj);
        }
        $result=$this->game->setSelectRolesByRoleId($map);
    }
    public function createRoom()
    {
        $db=new Db();
        $roomName = $_REQUEST["name"];
        $ip=$this->getIP();
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $time=time();
        $createSql="CREATE TABLE `rooms` (`id`  int NOT NULL AUTO_INCREMENT ,`name`  varchar(64) NULL ,`ip`  varchar(32) NULL ,`agent`  varchar(128) NULL ,`creatTime`  datetime NULL ,PRIMARY KEY (`id`))";
        if(!GUtils::isTableExist("rooms")){
            $db->exec($createSql);
        };
        $insertSql="INSERT INTO  `rooms` (`id`, `name`, `ip`, `agent`, `creatTime`) VALUES (null, :name, :ip,:agent, now())";
        $stmt = $db->dbh->prepare($insertSql);
        $stmt->bindParam("name", $roomName);
        $stmt->bindParam("ip",$ip );
        $stmt->bindParam("agent",$agent );
        $stmt->execute();
        $roomNum=$db->dbh->lastInsertId();



        $this->gameInfo->num=$roomNum;
        $this->gameInfo->name = $roomName;
        $this->gameInfo->agent = $agent;
        $this->gameInfo->createTime = $time;

        //创建房间表
        $roomTableName="room_".$roomNum;
        $createSql="CREATE TABLE `".$roomTableName."` (`id`  int NOT NULL AUTO_INCREMENT ,`serialize`  blob NULL ,`ips`  varchar(256),`txt`  varchar(128),`name`  varchar(128)  NULL ,`creatTime`  datetime NULL ,`updateTime`  datetime NULL ,PRIMARY KEY (`id`))";
        $db->exec($createSql);
        $insertSql="INSERT INTO `".$roomTableName."` (`id`, `serialize`,`ips`, `txt`, `name`, `creatTime`,`updateTime`) VALUES (null, :serialize,:ips ,:txt,:name, now(), now()) ";
        $stmt = $db->dbh->prepare($insertSql);
        $serialize=gzdeflate(serialize($this->game), 9);
        $stmt->bindParam("serialize", $serialize);
        $ips=$this->gameInfo->getAllIps();
        $stmt->bindParam("ips", $ips);
        $txt="";
        $stmt->bindParam("txt", $txt);
        $stmt->bindParam("name", $roomName);
        $stmt->execute();
        $db->close();

        return $roomNum;

    }
    public function isRoomExist($roomNum){
        $db=new Db();
         if(!$db->isTableExist("rooms")){
             return false;
         }
        $selectSql="select * from   `rooms`  where `id`=:id";
            $stmt = $db->dbh->prepare($selectSql);
            $stmt->execute(array(':id' => $roomNum));
        $rs = $stmt->fetchAll();
        $db->close();
        return !empty($rs);
    }
    public function load($roomNum){
        $db=new Db();
        $this->gameInfo->num=$roomNum;
        $roomTableName="room_".$this->gameInfo->num;
        //保存房间表
        $selectSql="select *  from  `".$roomTableName."` where id=1 for update";
        $rs= $db->query($selectSql);
        if(count($rs)!=1){
            echo "error".$roomTableName;return;
        }
        $db->close();
        $row=$rs[0];
        $this->game=unserialize(gzinflate($row['serialize']));
        $this->gameInfo->addAllIps($row['ips']);
        $this->gameInfo->name=$row['name'];
        $this->compere->setGame($this->game);
    }
    public function save(){
        $db=new Db();
        $roomTableName="room_".$this->gameInfo->num;
        //保存房间表
        $updateSql="update `".$roomTableName."` set  `serialize` =:serialize,`txt`=:txt,`name`=:name,`ips`=:ips,`updateTime`=now() where id=1";
        $stmt = $db->dbh->prepare($updateSql);
        $serialize=gzdeflate(serialize($this->game), 9);
        $stmt->bindParam("serialize",$serialize );
        $ips=$this->gameInfo->getAllIps();
        $stmt->bindParam("ips", $ips);
        $txt="";
        $stmt->bindParam("txt", $txt);
        $name=$this->gameInfo->name;
        $stmt->bindParam("name",$name);
        $stmt->execute();
        $db->close();
    }

    private function getIP()
    {
        $ip="";
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $ip = getenv("HTTP_CLIENT_IP");
            } else {
                $ip = getenv("REMOTE_ADDR");
            }
    }
        return $ip;
    }
}