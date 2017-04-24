<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/16
 * Time: 14:47
 */

namespace unit\lrs;
require_once 'role/Role.php';

class RoleManager{
    public  static function initRoles() {
        Role::initRoles();
    }

}