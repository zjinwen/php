<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/20
 * Time: 23:35
 */

namespace unit\lrs;

require_once 'dao/Db.php';
require_once 'GUtils.php';


header('Content-type:text/json');


 $result=null;
if(isset($_REQUEST['version'])){
    $version=$_REQUEST['version'];
    $db=new Db();
    $query="select * from `wk_version`  order by id desc limit 0,1 ";
    $rs=$db->query($query);
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
    $setPassword=$_REQUEST['setPassword'];
     if($setPassword!='3234963'){
         echo "false;;密码错误";
         return ;
     }

    $db=new Db();
    $time=time();
    $createSql="CREATE TABLE `wk_version` (`id`  int NOT NULL AUTO_INCREMENT ,`version` int not null ,`message`  varchar(256) NULL ,`name`  varchar(512) ,`url`  varchar(512)  ,`creatTime`  datetime NULL ,PRIMARY KEY (`id`))";
    if(!GUtils::isTableExist("wk_version")){
        $db->exec($createSql);
    };
    $insertSql="INSERT INTO  `wk_version` (`id`, `version`, `message`,`name`,`url`, `creatTime`) VALUES (null, :version, :message, :name,:url, now())";

    $stmt = $db->dbh->prepare($insertSql);
    $stmt->bindParam("version", $setVersion);
    $stmt->bindParam("message", $setMessage);
    $stmt->bindParam("name",$setName );
    $stmt->bindParam("url",$setUrl );
    $stmt->execute();
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

