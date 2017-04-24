<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


class Vote
{
    public  $pids;
    public  $has;
    public  $bpids;
    public  $time;

   public function __construct($pids,$bpids) {
       $this->pids = $pids;
       $this->bpids = $bpids;
       $this->time = time();
       $this->has = [];
   }



}