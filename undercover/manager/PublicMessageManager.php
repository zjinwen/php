<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;
require_once 'model/PublicMessage.php';

class PublicMessageManager
{

    public static function addMessage($gameModel,$message,$needConfirm=false) {
        $mid=1;
        if(count($gameModel->publicMs)!=0){
            $mid=$gameModel->publicMs[count($gameModel->publicMs)-1]->mid+1;
        };
        $pm=new PublicMessage($message,$needConfirm);
        $pm->mid=$mid;
        array_push($gameModel->publicMs,$pm);
        $gameModel->publicLast=$pm;
    }

    public static function clean($gameModel) {
        $gameModel->publicLast=null;
    }


    public static function getUserMessages($gameModel ,$pid,$lastMid) {
        $ms=[];
        if($pid<0)return $ms;
        foreach($gameModel->publicMs as $m){
            if($m->mid<=$lastMid){
                continue;
            }
            array_push($ms,$m);
        }
        return $ms;
    }
    public static function select($gameModel,$pid) {
        $message=$gameModel->publicLast;
        if($message==null){
            return null;
        }
        if(!$message->needConfirm){
            return null;
        }

        if(in_array($pid,$message->has)){
            return "已确认";
        }
        array_push($message->has,$pid);
        return null;
    }
    public static function isAllSelect($gameModel) {
        $message=$gameModel->publicLast;
        if($message==null){
            return true;
        }
        if(!$message->needConfirm){
            return true;
        }
        foreach ($gameModel->players as $p) {
            if(!$p->die){
                if(!in_array($p->num,$message->has)){
                      return false;
                }
            }
        }
        return true;
    }
}