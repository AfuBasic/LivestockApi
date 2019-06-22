<?php
/**
 * Created by PhpStorm.
 * User: Rade
 * Date: 1/25/2019
 * Time: 2:49 PM
 */

namespace Livestock247\Http\Controllers\v1;

use Livestock247\Http\Controllers\Controller;
use Livestock247\Models\livestockweight\StockWeight;

class LivestockWeight extends Controller
{
    public function getWeight($id)
    {
        $livestock = StockWeight::where('livestock_type', '=', $id)->select('id', 'name')->get();
        return $this->sendSuccess($livestock);
    }

}