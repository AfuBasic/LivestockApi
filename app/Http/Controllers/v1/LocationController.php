<?php
/**
 * Created by PhpStorm.
 * User: Rade
 * Date: 1/23/2019
 * Time: 1:51 PM
 */

namespace Livestock247\Http\Controllers\v1;

use Livestock247\Http\Controllers\Controller;
use App\Models\location\Location;

class LocationController extends Controller
{
    public function showLocation(){

        $locations = Location::all();

        return $this->sendSuccess($locations);
    }
}