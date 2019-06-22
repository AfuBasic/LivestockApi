<?php
/**
 * Authentication Controller
 * This class Authenticates a user, handles forgotten passwords
 * and resets passwords of users
 *
 * Created by Afuwape Tunde
 */

namespace Livestock247\Http\Controllers\v1;

use Livestock247\Constants\Constants;
use Livestock247\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Livestock247\Mail\ForgotPassword;
use Livestock247\Models\User;
use Livestock247\Constants\ResponseMessages;
use Livestock247\Constants\ResponseCodes;
use Livestock247\Models\ResetPassword;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $login = User::where('email',$request->input('email'))->where('password', md5($request->input('password')))->first();

        if (!$login) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_LOGIN],
                ResponseCodes::INVALID_LOGIN,
                200
            );
        }

        return $this->sendSuccess(['user' => $login]);
    }

    public function forgotPassword(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_USER],
                ResponseCodes::INVALID_USER,
                200
            );
        }

        $email  = $user->email;
        $hash   = strtolower(hash('sha512', mt_rand()));
        $password_reset = new ResetPassword();
        $password_reset->email = $email;
        $password_reset->hash = $hash;

        $mail_params = [
            'name'      => $user->firstname. ' ' .$user->lastname,
            'hash'      => $hash
        ];

        Mail::to($email)->send(new ForgotPassword((object)$mail_params));

        $password_reset->save();
        return $this->sendSuccess(['message' => Constants::MAIL_SENT_SUCCESS]);
    }

    public function resetPassword(Request $request, $hash)
    {
        $hash_check = ResetPassword::where('hash', $hash)->where('used', Constants::RESET_UNUSED)->first();
        if (!$hash_check) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_LINK],
                ResponseCodes::INVALID_LINK,
                200
            );
        }

        $email = $hash_check->email;
        $oldpassword = md5($request->input('oldpassword'));

        $check_user = User::where(['email' => $email, 'password' => $oldpassword])->first();

        if (!$check_user) {
            return $this->sendError(
                ['message' => ResponseMessages::INVALID_PASSWORD],
                ResponseCodes::INVALID_PASSWORD,
                200
            );
        }

        $user = User::where('email', $email)->first();
        $user->password = md5($request->input('password'));
        $user->save();

        ResetPassword::where('hash', $hash)->update(['used' => Constants::RESET_USED]);
        return $this->sendSuccess(['message' => Constants::PASSWORD_RESET_SUCCESS]);
    }
}