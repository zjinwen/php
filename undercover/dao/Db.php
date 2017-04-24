<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;


class Db
{
    const dbms='mysql';
    const  host='mysql';
    const dbName='u364299180_ygaru';
    const user='u364299180_aqule';
    const pass='ahaLuXeVyG';

    public  $dbh;
    function __construct() {
        $dsn=Db::dbms.":host=".Db::host.";dbname=".Db::dbName;
        try {
          $this->dbh = new \PDO($dsn, Db::user, Db::pass,array(\PDO::ATTR_PERSISTENT => true)); //初始化一个PDO对象
          $this->dbh ->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }

    }
    public function close(){
        $this->dbh=null;
    }

    public function query($sql){
        try {
           return $this->dbh->query($sql)->fetchAll() ;
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }
    public function exec($sql){
        try {
            return $this->dbh->exec($sql) ;
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }
    public function isTableExist($table){
        $sql=" SELECT CONCAT('drop table ',table_name,';')as ds FROM information_schema.`TABLES` WHERE table_schema='u364299180_ygaru' and    table_name = :table";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(':table' => $table));
        $rs = $stmt->fetchAll();
       return !empty($rs);
    }
    public function dropAllDb(){
       $sql=" SELECT CONCAT('drop table ',table_name,';')as ds FROM information_schema.`TABLES` WHERE table_schema='u364299180_ygaru' and    table_name not like 'wk_%'";
        foreach($this->query($sql) as $sq){
            $this->exec($sq[0]);
        }
    }

}