<?php
require_once '../ArrayTeller.php';
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/15
 * Time: 14:28
 */

class ArrayTellerTest extends PHPUnit_Framework_TestCase
{
    function testArrayTeller()
    {
        $at = new ArrayTeller();
        $result = $at->outputArray(1);
        $this->assertInternalType("array", $result);
        $this->assertCount(3, $result);
        $this->assertEquals(1, $result[0]);
        $this->assertEquals(3, $result[2]);

    }
}
