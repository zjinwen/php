<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;
require_once 'model/PrivateMessage.php';

class PrivateMessageManager
{
   public static function addMessage($gameModel,$pids,$message,$needConfirm=false) {
       if(count($pids)<=0)return false;
       $mid=1;
       if(count($gameModel->privateMs)!=0){
           $mid=$gameModel->privateMs[count($gameModel->privateMs)-1]->mid+1;
       };
       $pm=new PrivateMessage($pids,$message,$needConfirm);
       $pm->mid=$mid;
       array_push($gameModel->privateMs,$pm);
       $gameModel->privateLast=$pm;
   }
    public static function clean($gameModel) {
        $gameModel->privateLast=null;
    }

    public static function getUserPrivateMessage($gameModel ,$pid,$lastMid) {
        $ms=[];
        if($pid<0)return $ms;
        foreach($gameModel->privateMs as $m){
            if($m->mid<=$lastMid){
                continue;
            }
            if(in_array($pid,$m->ids)){
                array_push($ms,$m);
            }
        }
        return $ms;

    }

    public static function select($gameModel,$pid) {
        $message=$gameModel->privateLast;
        if($message==null){
            return null;
        }
        if(!$message->needConfirm){
            return null;
        }
        if(!in_array($pid,$message->ids)){
            return "不可确认";
        }
        if(in_array($pid,$message->has)){
            return "已确认";
        }
        array_push($message->has,$pid);
        return null;
    }
    public static function isAllSelect($gameModel) {

        $message=$gameModel->privateLast;

        if($message==null){
            return true;
        }
        if(!$message->needConfirm){
            return true;
        }

        return count($message->ids)==count($message->has);
    }
}