<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;
require_once 'dao/Db.php';
require_once 'model/GameInfo.php';
require_once 'model/GameModel.php';
require_once 'model/PublicMessage.php';
require_once 'model/PrivateMessage.php';
require_once 'model/Vote.php';

class RoomManager
{
    public static function createRoom()
    {
        $db=new Db();
        $roomName = $_REQUEST["name"];
        $ip=RoomManager::getIP();
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $time=time();
        $createSql="CREATE TABLE `rooms` (`id`  int NOT NULL AUTO_INCREMENT ,`name`  varchar(64) NULL ,`ip`  varchar(32) NULL ,`agent`  varchar(128) NULL ,`creatTime`  datetime NULL ,PRIMARY KEY (`id`))";
        if(!GUtils::isTableExist("rooms")){
            $db->exec($createSql);
        };
        $insertSql="INSERT INTO  `rooms` (`id`, `name`, `ip`, `agent`, `creatTime`) VALUES (null, :name, :ip,:agent, now())";
        $stmt = $db->dbh->prepare($insertSql);
        $stmt->bindParam("name", $roomName);
        $stmt->bindParam("ip",$ip );
        $stmt->bindParam("agent",$agent );
        $stmt->execute();
        $roomNum=$db->dbh->lastInsertId();
        $gameInfo=new GameInfo();
        $gameInfo->num=$roomNum;
        $gameInfo->name = $roomName;
        $gameInfo->agent = $agent;
        $gameInfo->createTime = $time;

        //创建房间表
        $roomTableName="room_".$roomNum;
        $createSql="CREATE TABLE `".$roomTableName."` (`id`  int NOT NULL AUTO_INCREMENT ,`serialize`  blob NULL ,`ips`  varchar(256),`txt`  varchar(128),`name`  varchar(128)  NULL ,`creatTime`  datetime NULL ,`updateTime`  datetime NULL ,PRIMARY KEY (`id`))";
        $db->exec($createSql);
        $insertSql="INSERT INTO `".$roomTableName."` (`id`, `serialize`,`ips`, `txt`, `name`, `creatTime`,`updateTime`) VALUES (null, :serialize,:ips ,:txt,:name, now(), now()) ";
        $stmt = $db->dbh->prepare($insertSql);
        $gameInfo->model = new GameModel();
        $serialize=gzdeflate(serialize($gameInfo->model), 9);
        $stmt->bindParam("serialize", $serialize);
        $ips=$gameInfo->getAllIps();
        $stmt->bindParam("ips", $ips);
        $txt="";
        $stmt->bindParam("txt", $txt);
        $stmt->bindParam("name", $roomName);
        $stmt->execute();
        $db->close();
        RoomManager::createRoomRoles($gameInfo);
        return $gameInfo;
    }

    private static function getIP()
    {
        $ip="";
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $ip = getenv("HTTP_CLIENT_IP");
            } else {
                $ip = getenv("REMOTE_ADDR");
            }
        }
        return $ip;
    }

    private static function createRoomRoles($gameInfo){
        $roleStr = $_REQUEST["roles"];
        $roles=explode(";", $roleStr);
        $map=[];
        foreach ($roles as $rs) {
            $is=explode("_", $rs);
            $roleId=$is[0];
            $roleIdNum=$is[1];
            $obj=(object)[];
            $obj->roleId=$roleId;
            $obj->roleIdNum=$roleIdNum;
            array_push($map,$obj);
        }
        RoomManager::setRolesByMap($map,$gameInfo);
        return  null;
    }

    private static  function setRolesByMap($map, $gameInfo)
    {
        $curNum=1;
        foreach ($map as $obj) {
            $found=null;
            foreach (Role::$roles as $sr) {
                if($sr->roleId==$obj->roleId){
                    if($obj->roleIdNum>$sr->max){
                        return $sr->name."超出最大数限制";
                    }
                    $found=$sr;
                    break;
                }
            }
            if($found!=null){
                for($i=0;$i<$obj->roleIdNum;$i++){
                    $player=new  Player(null,$curNum++,$found->roleId,"xx.png");
                    array_push($gameInfo->model->players,$player);
                }
            }
        }
        $gameInfo->model->playerCount= count($gameInfo->model->players);
    }

    public static function isRoomExist($roomNum){
        $db=new Db();
        if(!$db->isTableExist("rooms")){
            return false;
        }
        $selectSql="select * from   `rooms`  where `id`=:id";
        $stmt = $db->dbh->prepare($selectSql);
        $stmt->execute(array(':id' => $roomNum));
        $rs = $stmt->fetchAll();
        $db->close();
        return !empty($rs);
    }
    public static function load($roomNum){
        $db=new Db();
        $gameInfo=new GameInfo();
        $gameInfo->num=$roomNum;
        $roomTableName="room_".$gameInfo->num;
        //保存房间表
        $selectSql="select *  from  `".$roomTableName."` where id=1 for update";
        $rs= $db->query($selectSql);
        if(count($rs)!=1){
            echo "error".$roomTableName;return;
        }
        $db->close();
        $row=$rs[0];
        $game=unserialize(gzinflate($row['serialize']));
        $gameInfo->addAllIps($row['ips']);
        $gameInfo->name=$row['name'];
        $gameInfo->model=$game;
        RoleManager::initRoles();
        return $gameInfo;

    }
    public static function save($gameInfo){
        $db=new Db();
        $roomTableName="room_".$gameInfo->num;
        //保存房间表
        $updateSql="update `".$roomTableName."` set  `serialize` =:serialize,`txt`=:txt,`name`=:name,`ips`=:ips,`updateTime`=now() where id=1";
        $stmt = $db->dbh->prepare($updateSql);
        $serialize=gzdeflate(serialize($gameInfo->model), 9);
        $stmt->bindParam("serialize",$serialize );
        $ips=$gameInfo->getAllIps();
        $stmt->bindParam("ips", $ips);
        $txt="";
        $stmt->bindParam("txt", $txt);
        $name=$gameInfo->name;
        $stmt->bindParam("name",$name);
        $stmt->execute();
        $db->close();
    }
}