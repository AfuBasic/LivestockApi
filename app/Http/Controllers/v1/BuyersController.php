<?php
//Created By Esther Akowe

namespace Livestock247\Http\Controllers\v1;

use Illuminate\Http\Request;
use Livestock247\Models\BuyersDashboard;
use Livestock247\Http\Controllers\Controller;
use Livestock247\Models\Transaction;
use Livestock247\Models\Invoice;

class BuyersController extends Controller
{
  //Dashboard Count
  public function dashboard($uid)
  {

    $details= new Transaction();

    $analytics =
        [
            'analytics'=> [
                'paid_invoce' =>$details->paidTransaction($uid), 
                'total_transaction' => $details->analytics($uid),
            ],
            'recent_transaction' => $details->recentTransaction($uid),
        ];

      return $this->sendSuccess($analytics);
    }
}