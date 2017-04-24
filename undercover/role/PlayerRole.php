<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 16:47
 */

namespace unit\lrs;


class PlayerRole{

    function __construct($roleId,$configNum) {
        $this->roleId = $roleId;
        $this->configNum = $configNum;
        $this->left = $this->configNum;
    }



}