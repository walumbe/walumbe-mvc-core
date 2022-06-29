<?php

namespace app\core;

use app\core\db\DBModel;

/**
 * @author Jonathan Walumbe <nathanwalumbe@gmail.com>
 * @package app\core
 */
abstract class UserModel extends DBModel
{

    abstract public function getDisplayname():string;

}
