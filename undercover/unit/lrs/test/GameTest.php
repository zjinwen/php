<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 17:47
 */

namespace unit\lrs\test;

require_once '../../../Game.php';
require_once '../../../Compere.php';
require_once '../../../Chat.php';
require_once '../../../Group.php';
require_once '../../../Message.php';
require_once '../../../GameInfo.php';
use unit\lrs\Game;
use unit\lrs\Compere;
use unit\lrs\Chat;
use unit\lrs\Group;
use unit\lrs\Message;
use unit\lrs\GameInfo;
use unit\lrs\Role;


class GameTest extends \PHPUnit_Framework_TestCase
{


    function test1()
    {
        $game = new Game();
        $gameInfo = new GameInfo();
        $compere = new Compere($game);
        $this->assertCount(6, Role::$roles);
        $result= $this->addSetRoles($game);
        echo $result;
        $this->assertEquals(10,$game->playerCount);
        for ($x=0; $x<9; $x++) {
            $game->addPlayer("zhang".$x,"xxx.png");
        }
        $this->assertEquals(false,$game->isFull());
        $game->addPlayer("zhang10","xxx.png");
        $this->assertEquals(true,$game->isFull());

        $this->assertEquals(Game::GAME_STATUS_FULL,$game->status);

        foreach ($game->players as $p) {
          echo $p->name." ".strval($p->num)." ".$p->getName()."\n";
        }
        list($p, $rt) = $this->nightTime($compere, $game);

        $this->dayTime($compere, $game);
    }

    public function  addSetRoles($game){
        $result=$game->setSelectRoles(array(
            '普通村民' => 3,
            '狼人' => 3,
            '猎人' => 1,
            '预言家' => 1,
            '女巫' => 1,
            '禁言长老' => 1
        ));
        if($result!=null){
            echo $result;
        };

    }

    /**
     * @param $compere
     * @param $game
     * @return array
     */
    public function nightTime($compere, $game)
    {
        $compere->night();
        $this->assertEquals(Game::STATUS_NIGHT, $game->status);
        echo "夜晚玩家\n";
        foreach ($compere->getNightPlayers() as $p) {
            echo $p->name . " " . strval($p->num) . " " . $p->getName() . " " . $p->getRole()->nightOrder . "\n";
        }
        $nps = $compere->openEye();
        while (count($nps) > 0) {
            echo $nps[0]->getName() . "请睁眼\n";
            $game->chat->addGroup($nps, true);
            foreach ($nps as $p) {
                $rt = $game->select($game->players[2]->num, $p->num);
                if (!$rt) {
                    echo "error\n";
                }
            }
            $this->assertEquals(true, $game->isAllSelected());

            if ($nps[0]->getName() == '预言家') {
                if (!$nps[0]->die) {
                    $this->assertEquals(1, count($nps));
                    $nps[0]->setTellerExt($game->getMaxSelectPlayer());// 选择最大一个
                }
            }

            if ($nps[0]->getName() == '狼人') {
                $dieByWk = ($game->getMaxSelectPlayer());
                $compere->setWerewolvesKill($dieByWk);
            }
            if ($nps[0]->getName() == '女巫') {
                $witch = $game->lasttWitchExt;

                //test
                $witch->curUse = 'k';
                $witch->killUse = true;
                //
                if ($witch->curUse != null) {
                    if ($witch->curUse == 'k') {
                        $dieByWk = ($game->getMaxSelectPlayer());
                        $compere->setWitchDie($dieByWk);
                    } else if ($witch->curUse == 'l') {
                        $compere->setWitchLife();
                    }
                }
            }
            if ($nps[0]->getName() == '禁言长老') {
                $selectGap = ($game->getMaxSelectPlayer());
                $compere->setGagSelect($selectGap);
            }
            $nps = $compere->openEye();
        }
        return array($p, $rt);
    }

    /**
     * @param $compere
     * @param $game
     */
    public function dayTime($compere, $game)
    {
        echo "天亮了\n";
        if(!$game->hasPolice){
            $game->hasPolice=true;
            echo "竞选警长\n";
            $compere->beforePolice();
            $compere->forPolice(3);
            $compere->forPolice(2);
            $polices = $game->forPolices(true);
            $game->chat->addGroup($polices, false);

            foreach ($game->getChatPlayers() as $p) {
                $game->setChatCurrentSpeaker($p->num);
                $rt = $game->addChatMessage("xzcxzczxcsadas" . (string)time());
                if (!$rt) {
                    echo "error\n";
                }
            }
            $game->chat->addGroup($game->forPolices(false), true);

            foreach ($game->getChatPlayers() as $p) {
                $rt = $game->select($polices[rand(0, count($polices) - 1)]->num, $p->num);;
                if (!$rt) {
                    echo "error\n";
                }
            }
            $this->assertEquals(true, $game->isAllSelected());
            $selectPlayer = ($game->getMaxSelectPlayer());
            $game->police = $selectPlayer;
            echo "警长是" . $selectPlayer->num . "号\n";
        }

        $nps = $compere->day();
        echo $compere->dayMessage();

        //死亡遗言
        $dies = $compere->nightDies();
        $game->chat->addGroup($dies, false);
        foreach ($game->getChatPlayers() as $p) {
            $game->setChatCurrentSpeaker($p->num);
            $rt = $game->addChatMessage("xzcxzczxcsadas" . (string)time());
            if (!$rt) {
                echo "error\n";
            }
        }

        echo "白天发言：\n";
        $livePlayers = $game->livePlayers($dies);
        //$speakOrder
        $game->chat->addGroup($livePlayers, false);


        foreach ($game->getChatPlayers() as $p) {

            $game->setChatCurrentSpeaker($p->num);
            $rt = $game->addChatMessage("xzcxzczxcsadas" . (string)time());
            if (!$rt) {
                echo "error\n";
            }
        }


        $game->chat->addGroup($livePlayers, true);

        foreach ($game->getChatPlayers() as $p) {
            $rt = $game->select($livePlayers[rand(0, count($livePlayers) - 1)]->num, $p->num);;
            if (!$rt) {
                echo "error\n";
            }
        }

        $selectPlayer = ($game->getMaxSelectPlayer());

        $compere->setVote($selectPlayer);

        echo $compere->dayVoteMessage();
        //死亡遗言
        $game->chat->addGroup([$selectPlayer], false);
        foreach ($game->getChatPlayers() as $p) {
            $game->setChatCurrentSpeaker($p->num);
            $rt = $game->addChatMessage("xzcxzczxcsadas" . (string)time());
            if (!$rt) {
                echo "error\n";
            }
        }
    }
}
