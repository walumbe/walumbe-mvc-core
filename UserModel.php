<?php

namespace walumbe\phpmvc;

use walumbe\phpmvc\db\DBModel;

/**
 * @author Jonathan Walumbe <nathanwalumbe@gmail.com>
 * @package walumbe\phpmvc
 */
abstract class UserModel extends DBModel
{

    abstract public function getDisplayname():string;

}
