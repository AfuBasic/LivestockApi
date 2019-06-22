<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livestock247\Models\ApiAgents;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {

            $request_header = $request->headers->all();

            $public_key = $request_header['publickey'][0];
            $token = $request_header['token'][0];

            //Get merchant's private key
            $user = ApiAgents::where('api_token', $token)->where('status','enabled')->first();

            //Check for public key
            if (!is_null($user) && strtolower($public_key) === strtolower(hash('sha512', ($token . $user->private_key)))) {
                return $user;
            }

            return null;
        });
    }
}
