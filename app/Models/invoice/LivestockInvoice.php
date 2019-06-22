<?php
/**
 * Created by PhpStorm.
 * User: Rade
 * Date: 1/31/2019
 * Time: 8:50 AM
 */

namespace Livestock247\Models\invoice;

use Illuminate\Database\Eloquent\Model;
use Livestock247\Constants\Database;
use Livestock247\Constants\Constants;

class LivestockInvoice extends Model
{
    protected $table = Database::LIVESTOCK_INVOICE;

    public static function detail($id, $page, $limit, $offset)
    {
          return $rows = LivestockInvoice::selectRaw(Database::ACCOUNTS.'.name as acctname,'.Database::ACCOUNTS.'.phone as phone,'
          .Database::LIVESTOCK_INVOICE.'.invoice_date as date,'.Database::LIVESTOCK_INVOICE.'.invoice_no as invoice, '
          .Database::WEIGHT.'.name as weight,'.Database::ORDER.'.sex as sex,'.Database::ORDER.'.delivery_date as delivery_date,'
          .Database::ACCOUNTS.'.email as email,'. Database::LIVESTOCK_LOCATION.'.name as locationname,'
          .Database::LIVESTOCK_TYPE.'.name as typename,'.Database:: LIVESTOCK_INVOICE.'.livestock_cost as cost,'
          .Database::LIVESTOCK_INVOICE.'.inv_amount as totalprice,'.Database::CHIPPING.'.chip_no,'.Database::CHIPPING.'.pole_no')
            ->join(Database::ACCOUNTS, Database::ACCOUNTS.'.uid', Database::LIVESTOCK_INVOICE.'.uid')
            ->join(Database::ORDER, Database:: ORDER.'.uid', Database::LIVESTOCK_INVOICE.'.uid')
            ->join(Database::LIVESTOCK_TYPE, Database::ORDER.'.livestock_type', Database::LIVESTOCK_TYPE.'.id' )
            ->join(Database::LIVESTOCK_LOCATION , Database::ORDER.'.delivery_location', Database::LIVESTOCK_LOCATION.'.id')
            ->join(Database::CHIPPING , Database::ORDER.'.id', Database::CHIPPING.'.order_id')
            ->join(Database::WEIGHT , Database::ORDER.'.weight', Database::WEIGHT.'.id')
            ->where(Database::LIVESTOCK_INVOICE.'.uid', $id)
            ->skip($offset)
            ->take($limit)
            ->get();
    }

}

