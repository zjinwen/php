<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/20
 * Time: 23:35
 */

namespace unit\lrs;

require_once 'GameController.php';

class GameControllerTest extends \PHPUnit_Framework_TestCase
{
    function testCreateRoom(){

        $db=new Db();
        $db->dropAllDb();
        $db->close();
        $_REQUEST["name"]="干死你";
        $_SERVER["HTTP_USER_AGENT"]="android";
        $_SERVER["REMOTE_ADDR"]="127.0.0.1";
        $_REQUEST["roomNum"]=1;
        $_REQUEST["nickName"]="zjw";
        $_REQUEST["roles"]="1_3;2_3;4_1;5_1;6_1";
           /* (new Role(1,'普通村民',0,1,'',10,1))->setIsGood(true),
            (new Role(2,"狼人",2,1,"",10,1))->setIsGood(false),
            (new Role(3,"猎人",0,1,"",1,0))->setIsGood(true),
            (new Role(4,"预言家",1,1,"",1,0))->setIsGood(true),
            (new Role(5,"女巫",3,1,"",1,0))->setIsGood(true),
            (new Role(6,"禁言长老",4,1,"",1,0))->setIsGood(true)];*/

         $gc=new GameController();
         $gc->gameInfo->addIp("127.0.0.1");
         $gc->process("create");//同时设置角色

        for($i=0;$i<$gc->game->playerCount;$i++){
            $_REQUEST["roomNum"]=1;
            $_REQUEST["nickName"]="zjw";
            $gc->process("enter");
        }
        $this->assertEquals(9,$gc->game->playerCount);
        $this->assertEquals(Game::GAME_STATUS_FULL,$gc->game->status);
        //客户端 订阅请求
        $_REQUEST["pid"]=2;
        $_REQUEST["lastMid"]=-1;
        for($i=0;$i<$gc->game->playerCount;$i++){
            $_REQUEST["roomNum"]=1;
            $_REQUEST["pid"]=$i+1;
            $_REQUEST["lastMid"]=-1;
            $gc->process("message");
           // var_dump( );
        }


        $this->assertEquals(true,$gc->game->globalMsLast->isAllConfirm());
        sleep(2);
        $_REQUEST["roomNum"]=1;
        $_REQUEST["pid"]=$i+1;
        $_REQUEST["lastMid"]=-1;
        echo $gc->process("message");
        $this->assertEquals(true,$gc->game->globalMsLast->isAllConfirm());
        sleep(4);
        $this->assertEquals(true,$gc->game->globalMsLast->isAllConfirm());
        $_REQUEST["roomNum"]=1;
        $_REQUEST["pid"]=$i+1;
        $_REQUEST["lastMid"]=-1;
        echo $gc->process("message");
        $this->assertEquals(false,$gc->game->globalMsLast->isAllConfirm());




       // sleep(10);

        //$this->assertEquals(Game::GAME_STATUS_FULL,$game->status);
    }


}
