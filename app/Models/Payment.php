<?php
/**
 * Created by PhpStorm.
 * User: basic
 * Date: 2019-01-31
 * Time: 17:29
 */

namespace Livestock247\Models;

use Livestock247\Constants\Database;

class Payment extends BaseModel
{
    protected $table = Database::PAYMENTS;
}