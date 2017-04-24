<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


class PrivateMessage
{
    public  $mid;
    public  $message;
    public  $time;
    public  $ids;
    public  $needConfirm;
    public  $has;

   public function __construct($pids,$message,$needConfirm) {
       $this->message = $message;
       $this->ids = $pids;
       $this->needConfirm = $needConfirm;
       $this->time = time();
       $this->has = [];
   }


}