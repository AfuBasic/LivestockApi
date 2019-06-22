<?php
/**
 * Created by PhpStorm.
 * User: Rade
 * Date: 1/23/2019
 * Time: 4:35 PM
 */


namespace Livestock247\Http\Controllers\V1;

use Livestock247\Http\Controllers\Controller;
use Livestock247\Models\breed\Breeds;

class BreedListController extends Controller
{
    public function showBreed()
    {
        $breeds = Breeds::all();
        return $this->sendSuccess($breeds);
    }
}