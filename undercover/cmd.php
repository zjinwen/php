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

require_once 'controller/GameController2.php';



header('Content-type:text/json');
$gc=new GameController2();
echo json_encode($gc->process($_REQUEST["cmd"]));

