<?php
//Created By Esther Akowe

namespace Livestock247\Models;

use Livestock247\Constants\Constants;
use Livestock247\Constants\Database;
use Illuminate\Support\Facades\DB;

class Transaction extends BaseModel
{
    //Paid invoice count
    public function paidTransaction($uid)
    {
        $paid = DB::table(Database::LIVESTOCK_INVOICE)->where('status', '%d', $uid)->count();
        return $paid;
    }

    //Total Transaction count
    public function analytics($uid)
    {
    	$invoice_analytics = DB::table(Database::LIVESTOCK_INVOICE)->where('uid', $uid)->count();
        return $invoice_analytics;
    }

    //Recent Transaction details
    public function recentTransaction($uid)
    {
        $details = DB:: table(Database::LIVESTOCK_INVOICE)->select('inv_amount', 'invoice_no',  'status', 'updated_at')
        ->where('uid',$uid)->orderBy('updated_at', 'desc')->limit(config('config_' . env('APP_ENV') . '.invoice.recent'))->get();
        return $details;
    }
}