<?php
namespace unit\lrs;
use phpbrowscap\Exception;
require_once 'manager/PublicMessageManager.php';
require_once 'manager/CompereManager.php';


/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/2/21
 * Time: 10:45
 */
class StatusManager {

   const STATUS_BEFORE=1;
    const STATUS_START=2;
    const STATUS_NIGHT=3;

    const STATUS_ROLE_SEER=4;
    const STATUS_ROLE_WOLF=5;
    const STATUS_ROLE_WITCH=6;
    const STATUS_ROLE_GAG=7;

    const STATUS_POLICE_START=8;
    const STATUS_POLICE_SPEAK=9;
    const STATUS_POLICE_VOTE=10;

    const STATUS_DAY_START=11;
    const STATUS_DAY_POLICE_ORDER=12;
    const STATUS_DAY_SPEAK=13;
    const STATUS_DAY_VOTE=14;
    const STATUS_DAY_END=15;

    public static function nextStatus($gameModel,$currentStatus){
        $status=$gameModel->status;
        if(!PublicMessageManager::isAllSelect($gameModel)){
            throw new \Exception("PublicMessageManager::isAllSelect");
        };
        if(!PrivateMessageManager::isAllSelect($gameModel)){
            throw new \Exception("PrivateMessageManager::isAllSelect");
        };

        if($status!=$currentStatus&&$currentStatus!=-1)return;

        $compere =new  CompereManager($gameModel);
        switch ($status){
            case StatusManager::STATUS_BEFORE:
                PublicMessageManager::addMessage($gameModel,"游戏开始。\n天黑了请闭眼。",true);
                $gameModel->status= StatusManager::STATUS_START;
                break;
            case StatusManager::STATUS_START:
                $compere->night();
                $nps = $compere->openEye();
                if (count($nps) > 0) {
                    $role=$nps[0]->getRole();
                    $message = $role->name . "请睁眼," . ($nps[0]->getRole()->nightMessage) . "\n";//睁眼消息 ，开始投票
                 }
                break;
            default:throw new Exception("未知状态");break;
        }
     }


    public static function init($gameModel){
        $gameModel->status=StatusManager::STATUS_BEFORE;
        PublicMessageManager::addMessage($gameModel,"等待用户加入...");
    }

    public static function processStatus($gameModel){
        $status=$gameModel->status;
        switch ($status){
            case StatusManager::STATUS_BEFORE:

               return StatusManager::STATUS_START;
            default:throw new Exception("未知状态");break;
        }

    }


}