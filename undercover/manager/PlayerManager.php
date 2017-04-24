<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;

require_once 'manager/RoleManager.php';
require_once 'manager/RoomManager.php';
require_once 'manager/PlayerManager.php';
require_once 'manager/StatusManager.php';
require_once 'manager/VoteManager.php';
require_once 'manager/PublicMessageManager.php';
require_once 'manager/PrivateMessageManager.php';
require_once 'manager/SpeakManager.php.';

class PlayerManager
{

   public static function  confirm($gameInfo,$playerId,$publicId,$privateId){
       if($publicId!=-1){
           PublicMessageManager::select($gameInfo,$playerId);
       }
       if($privateId!=-1){
           PrivateMessageManager::select($gameInfo,$playerId);
       }

       if(PublicMessageManager::isAllSelect($gameInfo)){
           StatusManager::nextStatus($gameInfo->model,-1);
       }
       if(PrivateMessageManager::isAllSelect($gameInfo)){
           StatusManager::nextStatus($gameInfo->model,-1);
       }
    }

    private static function getPlayers($gameInfo){
        $ps=[];
        foreach ($gameInfo->model->players as $pl){
            $item=array(
                "n"=>$pl->num,
                "nm"=>$pl->name,
                "d"=>$pl->die,
                "r"=>$pl->getRole()->name
            );
            array_push($ps,$item);
        }
        return $ps;
    }

    public static function  getMessages($gameInfo,$playerId,$publicId,$privateId){
        $public=PublicMessageManager::getUserMessages($gameInfo->model,$playerId,$publicId);
        $private=PrivateMessageManager::getUserPrivateMessage($gameInfo->model,$playerId,$privateId);
        $vote=VoteManager::getUserVote($gameInfo->model,$playerId);
        $speak=SpeakManager::getCurrent($gameInfo->model,$playerId);

        $players=PlayerManager::getPlayers($gameInfo);
        $player=$gameInfo->model->getPlayerByNum($playerId);
        $rs= array("code"=>0,"ps"=>$public,"prs"=>$private,"v"=>$vote,"role"=>$player->getRole()->name,
        "spk"=>$speak,"users"=>$players
        );
        return $rs;
    }

   public static function enter($gameInfo,$nickName,$photo="",$pid="") {
       if($pid!=""){
           return PlayerManager::reenter($gameInfo,$nickName,$photo,$pid);
       }
       $freePlayer=[];
       foreach ($gameInfo->model->players as $sr) {
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

       if($freeRoleCount==1 ){//加满了
           StatusManager::nextStatus($gameInfo->model,StatusManager::STATUS_BEFORE);
       }
       return $sel->num;
   }
    private static function reenter($gameInfo,$nickName,$photo="",$pid="") {
        $selNum=null;
        foreach ($gameInfo->model->players as $sr) {
            if($sr->num==$pid){
                if($sr->name==null){
                    $sr->name=$nickName;
                }
                $sr->photo=$photo;
                $selNum=$sr->num;
            }
        }

        /*$all=true;
        foreach ($gameInfo->model->players as $sr2) {
            if($sr2->name==null){
                $all=false;
                break;
            }
        }
        if($all){
            if($gameInfo->model->status==GAME::GAME_STATUS_FREE){
                $gameInfo->model->status=GAME::GAME_STATUS_FULL;

            }
        }*/
        return $selNum;
    }
}