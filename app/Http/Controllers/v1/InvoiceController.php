<?php
/**
 * Created by PhpStorm.
 * User: Rade
 * Date: 1/31/2019
 * Time: 8:43 AM
 */


namespace Livestock247\Http\Controllers\v1;
use Illuminate\Http\Request;
use Livestock247\Http\Controllers\Controller;
use Livestock247\Models\invoice\LivestockInvoice;

class InvoiceController extends Controller
{
    public function getInvoice(Request $request, $id)
    {
        $page = $this->getPage();
        $limit = $this->getLimit();

        $offset = ($limit * ($page - 1));
        $invoice = LivestockInvoice::detail($id, $page, $limit, $offset);

        if ($invoice->isEmpty()) {
            return $this->sendSuccess(['data' => 'Details not found']);
        }

        return $this->sendSuccess($invoice);
    }


}