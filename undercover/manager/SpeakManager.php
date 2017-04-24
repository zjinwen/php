<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


use phpbrowscap\Exception;

class SpeakManager
{
    public static function getCurrent($gameModel,$pid) {
        if($gameModel->speakLast==null)return null;
        if(!in_array($pid,$gameModel->speakLast->pids)){
           return null;
        }
        return $gameModel->speakLast->current();
    }
    public static function clean($gameModel) {
        $gameModel->speakLast=null;
    }


    public static function create($gameModel,$pids,$bpids) {
          $v=new Speak($pids,$bpids);
          array_push($gameModel->speaks,$v);
          $gameModel->speakLast=$v;
    }
    public static function select($gameModel,$pid,$bpid) {
        $speak=$gameModel->speakLast;
        if($speak==null){
            throw new Exception("last speak is null");
        }

      /*  if(in_array($bpid,$speak->bpids)){
            return "不可用投票此人";
        }*/

        if(in_array($pid,$speak->pids)){
            return "不可发言";
        }
        if(in_array($pid,$speak->has)){
            return "已经发言";
        }
        array_push($speak->has,$pid);
        return null;
    }
    public static function isAllSelect($gameModel) {
        $speak=$gameModel->speakLast;
        if($speak==null){
            throw new Exception("last speak is null");
        }
        return count($speak->pids)==count($speak->has);
    }

}