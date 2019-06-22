<?php
/**
 * Created by PhpStorm.
 * User: Rade
 * Date: 1/25/2019
 * Time: 2:47 PM
 */

namespace Livestock247\Models\livestockweight;

use Illuminate\Database\Eloquent\Model;
use Livestock247\Constants\Database;

class StockWeight extends Model
{
    protected $table = Database::LIVESTOCK_WEIGHT;
}