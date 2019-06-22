<?php
/**
 * Created by PhpStorm.
 * User: basic
 * Date: 2019-01-25
 * Time: 11:55
 */

namespace Livestock247\Models;

use Livestock247\Constants\Database;

class Account extends BaseModel
{
    protected $table = Database::ACCOUNTS;
}