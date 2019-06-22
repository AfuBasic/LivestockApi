<?php
/**
 * Created by PhpStorm.
 * User: afuwape.tunde
 * Date: 23/04/2016
 * Time: 5:46 AM
 */

namespace Livestock247\Models;

use Livestock247\Constants\Constants;
use Livestock247\Constants\Database;

class ResetPassword extends BaseModel
{
    /**
     * @var   string
     */
    protected $table = Database::PASSWORD_RESET;
}