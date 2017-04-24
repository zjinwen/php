<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;
require_once 'dao/Db.php';
use unit\lrs\Db;

class GUtils
{

    public static function isTableExist($tableName){
        $db=new Db();
        $sql="select TABLE_NAME from INFORMATION_SCHEMA.TABLES where       TABLE_SCHEMA=:database and TABLE_NAME=:table ";
        $stmt = $db->dbh->prepare($sql);
        $database= Db::dbName;
        $stmt->bindParam("database",$database);
        $stmt->bindParam("table", $tableName);
        $stmt->execute();
        $rs = $stmt->fetchAll();
        $db->close();
        return (count($rs)>0);
    }

}