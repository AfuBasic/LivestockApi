<?php
/**
 * Created by PhpStorm.
 * User: Ayomide
 * Date: 1/25/2019
 * Time: 2:29 PM
 */

namespace Livestock247\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Livestock247\Constants\Constants;
use Livestock247\Constants\Database;
use Livestock247\Helpers\Utils;

class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'invoice_date', 'invoice_no', 'tp_type', 'livestock_cost', 'mtn_chip', 'phone',
        'sms', 'tp_cost', 'margin', 'agent', 'bank_charges', 'total', 'inv_total', 'inv_vat', 'inv_amount', 'status',
        'total_qty'
    ];

    protected $table= Database::LIVESTOCK_INVOICE;

    public function user()
    {
        return $this->belongsTo('Livestock247\User', 'uid');
    }
    public function comment()
    {
        return $this->hasMany('Livestock247\Models\Comments');
    }

    public function generateInvoice($id)
    {
        $invoice = new Invoice();
        $invoice->uid = $id;
        $invoice->invoice_date = date('Y-m-d');
        $invoice->invoice_no = Utils::generateUniqueInvoiceNo(md5(time().uniqid().mt_rand(10000, 99999)), Constants::INVOICE_CHAR_LENGHT);
        $invoice->mtn_chip = config('config_' . env('APP_ENV') . '.application.mtn_chip');
        $invoice->phone = config('config_' . env('APP_ENV') . '.application.phone_charges');
        $invoice->sms = config('config_' . env('APP_ENV') . '.application.sms_charges');
        $invoice->bank_charges = config('config_' . env('APP_ENV') . '.application.bank_charges');
        if($invoice->save()){
            return $invoice->id;
        }
        return false;
    }

    public function getSingleInvoiceByIdWithOrder($id)
    {
        return DB::table(Database::LIVESTOCK_INVOICE)
            ->leftJoin(Database::ORDER, Database::LIVESTOCK_INVOICE.'.id', '=', Database::ORDER.'.invoice_id')
            ->where(Database::LIVESTOCK_INVOICE.'.id', $id)
            ->first();
    }

    public function getSingleInvoiceById($id)
    {
        return DB::table(Database::LIVESTOCK_INVOICE)->where('id', $id)->first();
    }

    public function getAllUserInvoice($id)
    {
        return DB::table(Database::LIVESTOCK_INVOICE)
            ->leftJoin(Database::ORDER, Database::LIVESTOCK_INVOICE.'.id', '=', Database::ORDER.'.invoice_id')
            ->where(Database::LIVESTOCK_INVOICE.'.uid', $id)
            ->get();
    }

    public function updateAllInvoiceColumns($id,$data)
    {
        return Invoice::where('id', $id)->update($data);
    }

}