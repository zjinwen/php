<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


class GameInfo
{
    public  $name="";//房间名称
    public  $photo="";//头像
    public  $num=0; //房间号
    public  $agent=""; //浏览器
    public  $createTime=0; //创建时间
    public  $modifyTime=0; //修改时间
    public  $ips=[]; //全部ip时间

    public $model;//数据

   public function getAllIps(){
       $str="";
       foreach ($this->ips  as $p) {
           $str=$str.$p.";";
       }
       return $str;
   }

    public function addAllIps($ips){
             foreach (explode (';', $ips)  as $p) {
                 if($p!=null&&strlen($p)>0){
                     $this->addIp($p);
                 }
             }
    }
    public function addIp($ip){
         if(!in_array($ip,$this->ips)){
             array_push($this->ips,$ip);
         }
   }
}