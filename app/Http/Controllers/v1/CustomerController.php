<?php
/**
 * Customer Controller Class
 * This Class handles all Customer related actions for the API
 *
 * Created by Afuwape Tunde
 */
namespace Livestock247\Http\Controllers\v1;

use Livestock247\Constants\Constants;
use Livestock247\Constants\Database;
use Livestock247\Http\Controllers\Controller;
use Livestock247\Constants\ResponseMessages;
use Livestock247\Constants\ResponseCodes;
use Illuminate\Http\Request;
use Livestock247\Models\Account;
use Validator;
use Illuminate\Support\Facades\Mail;
use Livestock247\Models\User;
use Livestock247\Models\ActivationCode;
use Livestock247\Mail\Registeration;
use Livestock247\Helpers\Utils;

class CustomerController extends Controller
{
    private $customer;
    public function addCustomer(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'firstname'         => 'required|alpha',
            'lastname'          => 'required|alpha',
            'phone'             => 'required|unique:'.Database::ACCOUNTS,
            'state'             => 'required',
            'contact_address'   => 'required',
            'gender'            => 'required',
            'email'             => 'required|email|unique:'.Database::USERS,
            'password'          => 'required',
           'state_id'           => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError(
                ['message' => $validator->errors()->all()],
                ResponseCodes::INVALID_PARAMS,
                200
            );
        }

        $data = $request->input();
        $data['password']       = strtolower(md5($data['password']));
        $data['activkey']      = substr(strtoupper(uniqid()), 7 );

        $this->customer = [
            'name' => $data['firstname']. ' ' .$data['lastname'],
            'email' => $data['email']
            ];

        $users = new User();
        $activation_code = new ActivationCode();
        $account = new Account();


        $users->email = $data['email'];
        $users->password = md5($data['password']);

        $hash = hash('sha512',mt_rand());
        $mail_params   = [
          'name'    => $data['firstname']. ' ' .$data['lastname'],
          'code'    => $data['activkey'],
            'hash'  => $hash
        ];

        $activation_code->email = $data['email'];
        $activation_code->hash = $hash;
        $activation_code->code = $data['activkey'];
        $activation_code->used = Constants::STATUS_INACTIVE;

        $users->save();
        $activation_code->save();

        $account->uid = $users->id;
        $account->name = $data['firstname']. ' ' .$data['lastname'];
        $account->phone = $data['phone'];
        $account->email = $data['email'];
        $account->state_id = $data['state_id'];
        $account->address = $data['contact_address'];
        $account->account_type = Constants::STATUS_ACTIVE ;

        $account->save();

        Mail::to($data['email'])->send(new Registeration((object)$mail_params));

        return $this->sendSuccess(['message' => Constants::REGISTRATION_SUCCESS]);
    }

    public function activate($hash)
    {
        $activation = ActivationCode::where('hash', '=', $hash)->first();
        if (!$activation) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_LINK],
                ResponseCodes::INVALID_LINK,
                200
            );
        }

        $customer = Account::where('email', '=', $activation->email)->first();

        $time_code_sent = strtotime($activation->created_at);
        if (Utils::getTimeDifference($time_code_sent, time()) > Constants::MESSAGE_VERIFICATION_EXPIRY ) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_LINK],
                ResponseCodes::INVALID_LINK,
                200
            );
        }

        if (!$customer) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_LINK],
                ResponseCodes::INVALID_LINK,
                200
            );
        }

        $customer->status = Constants::STATUS_ACTIVE;
        $customer->save();

        ActivationCode::where('id', $activation->id)->update(['used' => Constants::STATUS_ACTIVE]);
        return $this->sendSuccess(['message' => Constants::ACTIVATION_SUCCESS]);
    }

    public function verifyCode(Request $request)
    {
        $customer = Account::find($request->input('user_id'));
        if (!$customer) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_CODE_USER],
                ResponseCodes::INVALID_CODE_USER,
                200
            );
        }

        $activation = ActivationCode::where('code', $request->input('code'))->where('used', Constants::STATUS_INACTIVE)->first();
        if (!$activation) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_CODE],
                ResponseCodes::INVALID_CODE,
                200
            );
        }

        $time_code_sent = strtotime($activation->created_at);
        if (Utils::getTimeDifference($time_code_sent, time()) > Constants::MESSAGE_VERIFICATION_EXPIRY ) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_CODE],
                ResponseCodes::INVALID_CODE,
                200
            );
        }
        $customer->status = Constants::STATUS_ACTIVE;
        $customer->save();

        ActivationCode::where('id', $activation->id)->update(['used' => Constants::STATUS_ACTIVE]);
        return $this->sendSuccess(['message' => Constants::ACTIVATION_SUCCESS]);
    }

    public function resendCode($id)
    {
        $user = Account::find($id);
        if (!$user) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_USER],
                ResponseCodes::INVALID_USER,
                200
            );
        }
        ActivationCode::where('email', $user->email)->update(['used' => Constants::STATUS_ACTIVE]);

        $email = $user->email;
        $hash = strtolower(hash('sha512', mt_rand()));
        $code = substr(strtoupper(uniqid()), 7 );

        $activation_code = new ActivationCode();
        $activation_code->email = $email;
        $activation_code->hash = $hash;
        $activation_code->code = $code;

        $mail_params = [
            'name'      => $user->firstname. ' ' .$user->lastname,
            'code'      => $code,
            'hash'      => $hash
        ];
        Mail::to($email)->send(new Registeration((object)$mail_params));
        $activation_code->save();

        return $this->sendSuccess(['message' => Constants::MAIL_SENT_SUCCESS]);
    }
}