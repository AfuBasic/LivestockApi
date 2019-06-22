<?php
/**
 * Created by PhpStorm.
 * User: Ayomide
 * Date: 1/21/2019
 * Time: 11:54 PM
 */

namespace Livestock247\Helpers;

use Illuminate\Support\Facades\Validator;


class Validate extends Validator
{
    public static function validateOrder($data)
    {
        $v =  Validator::make($data, [
            'delivery_date' => 'required|date',
            'delivery_period' => 'required',
            'delivery_location' => 'required',
            'address' => 'required',
            'orders' => 'required',
        ]);
        return $v;
    }

    public static function validateComment($data)
    {
        $v =  Validator::make($data, [
            'comment' => 'required',
        ]);
        return $v;
    }
    public static function validateChip($data)
    {
        $v =  Validator::make($data, [
            'chips' => 'required',
            'user_id' => 'required',
        ]);
        return $v;
    }
}