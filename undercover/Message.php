<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


class Message
{
    public  $id;
    public  $playerId;
    public  $message;
    public  $time;

    function __construct($playerId,$message) {
        $this->playerId = $playerId;
        $this->message = $message;
        $this->time=time();
    }



}