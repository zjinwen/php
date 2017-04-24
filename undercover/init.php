

<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/2/21
 * Time: 10:50
 */


echo  "<h2>init config:</h2>". date("h:i:sa");;

?>

<?php


$dbms='mysql';     //数据库类型
$host='mysql'; //数据库主机名
$dbName='u364299180_ygaru';    //使用的数据库
$user='u364299180_aqule';      //数据库连接用户名
$pass='ahaLuXeVyG';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";

try {
    $dbh = new PDO($dsn, $user, $pass,array(PDO::ATTR_PERSISTENT => true)); //初始化一个PDO对象

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->exec('set names utf8');

    echo "连接成功<br/>";

    /*foreach ($dbh->query('SELECT * from tswk_posts ') as $row) {
        print_r($row); //你可以用 echo($GLOBAL); 来看到这些值
    }*/


    // sql to create table
        $sqlRooms = "drop table if exists wk_room;CREATE TABLE wk_room (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        name VARCHAR(30) NOT NULL,
        number VARCHAR(30) NOT NULL,
        createDate TIMESTAMP,
        updateDate TIMESTAMP,
        roles VARCHAR(256),
        status int 
        )";
       $sqlRoles = "drop table if exists wk_role;CREATE TABLE wk_role (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(30) NOT NULL,
        `desc` VARCHAR(30) NOT NULL,
        photo VARCHAR(125) NOT NULL,
        nightOrder INT(6) NOT NULL,
        viewOrder INT(6),
        ops VARCHAR(30),
        createDate TIMESTAMP,
        updateDate TIMESTAMP
        )";
       $sqlUser = "drop table if exists wk_user;CREATE TABLE wk_user (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(30) NOT NULL,
        `mobile` VARCHAR(30) ,
        email VARCHAR(50),
        loginDate TIMESTAMP,
        createDate TIMESTAMP,
        updateDate TIMESTAMP
        )";
        // use exec() because no results are returned
    $dbh->exec($sqlRooms);
    $dbh->exec($sqlRoles);
    $dbh->exec($sqlUser);

    $dbh->exec("INSERT INTO `wk_role` (`id`,`name`,`desc`,`photo`,`nightOrder`,`viewOrder`,`ops`,`createDate`,`updateDate`)VALUES (null,'普通村民',' asdsa','images/e61190ef76c6a7efcaaa1dbaf5faaf51f2de6699.jpg',10,1,'',now(),now())");
   $dbh->exec("INSERT INTO `wk_role` (`id`,`name`,`desc`,`photo`,`nightOrder`,`viewOrder`,`ops`,`createDate`,`updateDate`)VALUES (null,'狼人',' asdsa','images/bd315c6034a85edf9f8748bf41540923dd547526.jpg',9,1,'',now(),now())");
   $dbh->exec("INSERT INTO `wk_role` (`id`,`name`,`desc`,`photo`,`nightOrder`,`viewOrder`,`ops`,`createDate`,`updateDate`)VALUES (null,'猎人',' asdsa','images/728da9773912b31bcd3d7cb58e18367adbb4e1dd.jpg',8,1,'',now(),now())");
    $dbh->exec("INSERT INTO `wk_role` (`id`,`name`,`desc`,`photo`,`nightOrder`,`viewOrder`,`ops`,`createDate`,`updateDate`)VALUES (null,'预言家',' asdsa','images/1ad5ad6eddc451dacf17bb77befd5266d116324c.jpg',7,1,'',now(),now())");
   $dbh->exec("INSERT INTO `wk_role` (`id`,`name`,`desc`,`photo`,`nightOrder`,`viewOrder`,`ops`,`createDate`,`updateDate`)VALUES (null,'女巫',' asdsa','images/42166d224f4a20a4e9968a5b98529822730ed0a6.jpg',6,1,'',now(),now())");
   $dbh->exec("INSERT INTO `wk_role` (`id`,`name`,`desc`,`photo`,`nightOrder`,`viewOrder`,`ops`,`createDate`,`updateDate`)VALUES (null,'禁言长老',' asdsa','images/71cf3bc79f3df8dc39e86bdbc411728b461028a7.jpg',5,1,'',now(),now())");

    echo $dbh->lastinsertid();

    echo "Tables   created successfully";
        $dbh = null;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}
//默认这个不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true) 变成这样：
//$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
?>
