<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


class PublicMessage
{

    public  $mid;
    public  $message;
    public  $time;
    public  $needConfirm;
    public  $has;

   public function __construct($message,$needConfirm) {
       $this->message = $message;
       $this->time = time();
       $this->needConfirm = $needConfirm;
       $this->has = [];
   }


}