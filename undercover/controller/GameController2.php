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
require_once 'model/GameInfo.php';
require_once 'dao/Db.php';
require_once 'GUtils.php';
require_once 'manager/RoleManager.php';
require_once 'manager/RoomManager.php';
require_once 'manager/PlayerManager.php';
require_once 'manager/StatusManager.php';
require_once 'manager/VoteManager.php';

use unit\lrs\Game;
use unit\lrs\Compere;
use unit\lrs\Chat;
use unit\lrs\Group;
use unit\lrs\Message;
use unit\lrs\GameInfo;
use unit\lrs\Role;
use unit\lrs\Db;
use unit\lrs\GUtils;

class GameController2
{

    function __construct() {

    }

    public function getMessage($code,$message){
        return  array("code"=>$code,"message"=>$message);
    }
    public function getSuccessMessage($message){
        return $this->getMessage(0,$message);
    }
    public function getErrorMessage($message){
        return $this->getMessage(1,$message);
    }

    public function  process($cmd){
        $roomNum =null;
        if(isset($_REQUEST['roomNum'])){
            $roomNum =$_REQUEST["roomNum"];
        }
         if( !is_null($roomNum)&&$cmd!='create'){
            if(!RoomManager::isRoomExist($roomNum)) {
                return $this->getErrorMessage($roomNum."房间号不存在");
            }
         }

            switch ($cmd){
                case "create":
                    $gameInfo=RoomManager::createRoom();
                    StatusManager::init($gameInfo->model);
                    RoomManager::save($gameInfo);
                    return $this->getSuccessMessage($gameInfo->num);
                    break;
                case "enter":

                    if(is_null($roomNum)||is_null($_REQUEST["nickName"])){
                        return $this->getErrorMessage("请填写 roomNum nickName");
                    }
                    $gameInfo=RoomManager::load($roomNum);
                    $pid="";
                    if(isset($_REQUEST['pid'])){
                        $pid=$_REQUEST['pid'];
                    }
                    $nickName= $_REQUEST["nickName"];
                    $selNum=PlayerManager::enter($gameInfo,$nickName,"",$pid);
                    if($selNum!=null){
                        RoomManager::save($gameInfo);
                       // $this->setCookie("pid",$sel->num);
                       // $this->setCookie("roomNum",$roomNum);
                        return $this->getSuccessMessage($selNum);
                    }else{
                        return $this->getErrorMessage("进入房间失败");
                    }
                    break;
                case "message"://客户端 订阅请求
                    if($roomNum==null||!isset($_REQUEST["pid"])){
                        return $this->getErrorMessage($roomNum."请重新进入房间");
                    }
                    $gameInfo=RoomManager::load($roomNum);
                    $playerId=$_REQUEST["pid"];
                    $publicId=-1;
                    $privateId=-1;

                    if(isset($_REQUEST['publicId'])){
                        $publicId=$_REQUEST["publicId"];
                    }
                    if(isset($_REQUEST['privateId'])){
                        $privateId=$_REQUEST["privateId"];
                    }
                    $json= PlayerManager::getMessages($gameInfo,$playerId,$publicId,$privateId);
                    //$json= $this->game->getMessages($playerId,$lastMid,$lastCid,$lastPmid,$this);
                    RoomManager::save($gameInfo);
                    return $json;
                    break;
                case "confirm"://客户端收到消息
                    if($roomNum==null||!isset($_REQUEST["pid"])){
                        return $this->getErrorMessage($roomNum."请重新进入房间");
                    }
                    $gameInfo=RoomManager::load($roomNum);
                    $playerId=$_REQUEST["pid"];
                    $publicId=-1;
                    $privateId=-1;
                    if(isset($_REQUEST['publicId'])){
                        $publicId=$_REQUEST["publicId"];
                    }
                    if(isset($_REQUEST['privateId'])){
                        $privateId=$_REQUEST["privateId"];
                    }
                    $json= PlayerManager::confirm($gameInfo,$playerId,$publicId,$privateId);
                    //$json= $this->game->getMessages($playerId,$lastMid,$lastCid,$lastPmid,$this);
                    RoomManager::save($gameInfo);
                    return $json;
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




}