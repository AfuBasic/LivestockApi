<?php
/**
 * Created by PhpStorm.
 * User: basic
 * Date: 2019-02-01
 * Time: 13:40
 */

namespace Livestock247\Models;

use Livestock247\Constants\Database;

class PaymentLog extends BaseModel
{
    protected $table = Database::PAYMENT_LOG;
}