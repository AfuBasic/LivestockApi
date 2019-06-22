<?php
/**
 * Created by PhpStorm.
 * User: Rade
 * Date: 1/23/2019
 * Time: 3:31 PM
 */
namespace Livestock247\Http\Controllers\v1;

use Livestock247\Http\Controllers\Controller;
use Livestock247\Models\livestocktype\Livestocktype;
use Illuminate\Http\Request;
use Livestock247\Models\LivestockWeight;

class LivestockTypeController extends Controller
{
    public function showLivestockType()
    {
        $types = LivestockType::all();
        return $this->sendSuccess($types);
    }

    public function updateWeight(Request $request)
    {
        $livestock_weight = $this->validate($request, [
            'livestock_type' => 'required'
        ]);

        LivestockWeight::where('livestock_type')->update(['livestock_type' => $request->input('livestock_type')]);
        return $this->sendSuccess($livestock_weight);
    }
}