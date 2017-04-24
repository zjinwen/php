<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/20
 * Time: 23:35
 */

namespace unit\lrs;
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require_once 'dao/Db.php';
require_once 'GUtils.php';

/* 101game.esy.es/filetransfer/update.php?setVersion=2&setMessage=更新bug&setName=bug&setPassword=3234963&type=client&setUrl=http://www.baidu.com */
header('Content-type:text/json');
$tableVersionType="wk_type_version";
$result=null;
if(isset($_REQUEST['version'])&&isset($_REQUEST['type'])){
    $version=$_REQUEST['version'];
    $type=$_REQUEST['type'];
    $db=new Db();
    $query="select * from ".$tableVersionType." where type=:type order by id desc limit 0,1 ";

    $stmt = $db->dbh->prepare($query);
    $stmt->bindParam(":type",$type);
    $stmt->execute();
    $rs=$stmt->fetchAll();
    $stmt->closeCursor();
    $name=null;
    $message=null;
    $versionLast=0;
    $url="";

    if($rs!=null&&count($rs)>0&&($version<$rs[0]['version'])){
        $name=$rs[0]['name'];
        $message=$rs[0]['message'];
        $url=$rs[0]['url'];
       // echo json_encode(array("update"=>true,"name"=>$name,"message"=>$message,"url"=>$url));
        echo "true;;$name;;$message;;$url";
        $db->close();
        return ;
    }else{
        $db->close();
       // echo json_encode(array("update"=>false));

        echo "false;;不需要更新".count($rs);
        return ;
    }
}

if(isset($_REQUEST['setVersion'])){

    $ip=getIP();
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $setVersion=$_REQUEST['setVersion'];
    $setMessage=$_REQUEST['setMessage'];
    $setName=$_REQUEST['setName'];
    $setUrl=$_REQUEST['setUrl'];
    $type=$_REQUEST['type'];
    $setPassword=$_REQUEST['setPassword'];

     if($setPassword!='3234963'){
         echo "false;;密码错误";
         return ;
     }


    $db=new Db();
    $time=time();
    $createSql="CREATE TABLE  ".$tableVersionType."  (`id`  int NOT NULL AUTO_INCREMENT ,`type` varchar(126) ,`version` int not null ,`message`  varchar(256) NULL ,`name`  varchar(512) ,`url`  varchar(512)  ,`creatTime`  datetime NULL ,PRIMARY KEY (`id`))";
    if(!GUtils::isTableExist($tableVersionType)){
        $db->exec($createSql);
    };
    $insertSql="INSERT INTO   ".$tableVersionType."  (`id`, `version`,`type`, `message`,`name`,`url`, `creatTime`) VALUES (null, :version,:type,:message, :name,:url, now())";

    $stmt = $db->dbh->prepare($insertSql);
    $stmt->bindParam("version", $setVersion);
    $stmt->bindParam("type",$type );
    $stmt->bindParam("message", $setMessage);
    $stmt->bindParam("name",$setName );
    $stmt->bindParam("url",$setUrl );
    $stmt->execute();
    $stmt->closeCursor();
    $db->close();

    echo "true;;$setVersion";
    return ;
}



 function getIP(){
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

echo json_encode(array("success"=>false,"error"=>"请选择操作"));
return;


?>

