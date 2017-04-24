<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


use phpbrowscap\Exception;

class VoteManager
{
    public static function getUserVote($gameModel,$pid) {
        if($gameModel->voteLast==null)return null;
        if(!in_array($pid,$gameModel->voteLast->pids)){
           return null;
        }
        return $gameModel->voteLast;
    }
    public static function clean($gameModel) {
        $gameModel->voteLast=null;
    }


    public static function create($gameModel,$pids,$bpids) {
          $v=new Vote($pids,$bpids);
          array_push($gameModel->votes,$v);
          $gameModel->voteLast=$v;
    }
    public static function select($gameModel,$pid,$bpid) {
        $vote=$gameModel->voteLast;
        if($vote==null){
            throw new Exception("last vote is null");
        }

        if(in_array($bpid,$vote->bpids)){
            return "不可用投票此人";
        }

        if(in_array($pid,$vote->pids)){
            return "不可投票";
        }
        if(in_array($pid,$vote->has)){
            return "已经投票";
        }
        array_push($vote->has,$pid);
        return null;
    }
    public static function isAllSelect($gameModel) {
        $vote=$gameModel->voteLast;
        if($vote==null){
            throw new Exception("last vote is null");
        }
        return count($vote->pids)==count($vote->has);
    }

}