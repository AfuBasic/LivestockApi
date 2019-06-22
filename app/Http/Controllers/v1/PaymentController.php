<?php
/**
 * Created by PhpStorm.
 * User: Afuwape Tunde
 * Date: 2019-01-30
 * Time: 12:17
 */

namespace Livestock247\Http\Controllers\v1;

use Livestock247\Constants\Database;
use Livestock247\Constants\ResponseCodes;
use Livestock247\Constants\ResponseMessages;
use Livestock247\Helpers\Utils;
use Livestock247\Models\Account;
use Livestock247\Models\Payment;
use Livestock247\Models\PaymentLog;
use Validator;
use Livestock247\Constants\Constants;
use Livestock247\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_id' => 'required',
            'invoice_no' => 'required|unique:' . Database::PAYMENT_LOG,
            'item_desc' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'gateway_id' => 'required',
            'return_url' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError(
                ['message' => $validator->errors()->all()],
                ResponseCodes::INVALID_PARAMS,
                200
            );
        }

        $customer = Account::find($request->input('user_id'));

        $endpoint = config('config_' . env('APP_ENV') . '.application.sana_pay_staging');
        $endpoint = $endpoint . config('config_' . env('APP_ENV') . '.application.merchant_code');
        $uniq_id = md5(uniqid());
        $start = rand(0, strlen($uniq_id) / 2);
        $transaction_id = substr($uniq_id, $start, $start + Constants::TRANSACTION_ID_LENGTH);
        $request_xml = '<?xml version="1.0" encoding="UTF-8"?>
                        <order>
                            <MerchantServiceId>' . config('config_' . env('APP_ENV') . '.application.test_merchant_service_id') . '</MerchantServiceId>
                                    <MerchantTransactionNumber>' . $transaction_id . '</MerchantTransactionNumber>
                                    <CustomerName>' . $customer->name . '</CustomerName>                                    
                                    <CustomerEmail> ' . $customer->email . ' </CustomerEmail>
                                    <ItemDescription> ' . $request->input('item_desc') . ' </ItemDescription>
                                    <Amount>' . $request->input('amount') . '</Amount>
                                    <ref_no>' . $transaction_id . '</ref_no>
                                    <Currency>566</Currency>                                    
                                   	<ReturnURL>' . $request->input('return_url') . '</ReturnURL>
                                    <CancelURL> ' . $request->input('cancel_url') . ' </CancelURL>
                                    <FailURL> ' . $request->input('failed_url') . ' </FailURL>
                        </order>';

        $e3D = Utils::get3DESencryptioncode(config('config_' . env('APP_ENV') . '.application.authorization'), config('config_' . env('APP_ENV') . '.application.e3des'));
        $header[] = 'Authorization: ' . $e3D;
        $header[] = 'Content-Type: application/xml;charset=UTF-8';
        $header[] = 'Accept: application/xml;charset=UTF-8 ';

        $ch = curl_init(); //initialize curl handle
        curl_setopt($ch, CURLOPT_URL, $endpoint); //set the url
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return as a variable
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1); //set POST method
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_xml); //set the POST variables
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        $response = curl_exec($ch);
        $xdoc = new \DOMDocument();
        $isLoaded = $xdoc->loadXML($response);

        $url = $xdoc->getElementsByTagName('RedirectURL')->item(0)->nodeValue;

        //Begin Taking Payment Record

        $payment = new PaymentLog();
        $payment->uid = $request->input('user_id');
        $payment->order_id = $request->input('order_id');
        $payment->invoice_no = $request->input('invoice_no');
        $payment->gateway_id = $request->input('gateway_id');
        $payment->amount = $request->input('amount');
        $payment->reference = $transaction_id;
        $payment->status = '0';

        $payment->save();

        return $this->sendSuccess(['payment_id' => $payment->id, 'redirect_url' => $url]);
    }

    public function update(Request $request, $id, $status)
    {
        $payment = PaymentLog::find($id);
        if (!$payment) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_PAYMENT],
                ResponseCodes::INVALID_PAYMENT,
                200
            );
        }

        if (!$request->input()) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_PARAMS],
                ResponseCodes::INVALID_PARAMS,
                200
            );
        }

        if ($status > Constants::PAYMENT_FAILED) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_PAYMENT_STATUS],
                ResponseCodes::INVALID_PAYMENT_STATUS,
                200
            );
        }

        $other_details = json_encode($request->input());

        $payment->status = $status;
        $payment->update_time = date('Y-m-d H:i:s');
        $payment->gateway_reference = $request->input('trnref');
        $payment->gateway_other_details = $other_details;
        $payment->save();

        return $this->sendSuccess(['message' => Constants::PAYMENT_UPDATE_SUCCESS]);
    }

    public function getPayment($reference)
    {
        $payment = PaymentLog::where('reference', $reference)->first();
        if (!$payment) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_PAYMENT],
                ResponseCodes::INVALID_PAYMENT,
                200
            );
        }

        $endpoint = config('config_' . env('APP_ENV') . '.application.sana_pay_requery');
        $request_xml = '<?xml version="1.0" encoding="UTF-8"?>
                            <TransactionDetailsRequest>
                                <TransactionNumber>'.$reference.'</TransactionNumber>
                            </TransactionDetailsRequest>';

        $ch = curl_init(); //initialize curl handle
        curl_setopt($ch, CURLOPT_URL, $endpoint); //set the url
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return as a variable
        curl_setopt($ch, CURLOPT_POST, 1); //set POST method
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_xml); //set the POST variables
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        $response = curl_exec($ch);
        $isLoaded = new \SimpleXMLElement($response);

        return $this->sendSuccess($isLoaded);

    }
}