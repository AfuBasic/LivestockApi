<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $request_header = $request->headers->all();
        if (!isset($request_header['publickey']) || !isset($request_header['token'])) {
            return response(['status' => 'error', 'message' => 'You don\'t come to a party without your Token and Public key.'], 401);
        }

        if ($this->auth->guard($guard)->guest()) {
            return response(['status' => 'error', 'message' => 'I lost my glasses so I am finding it hard to find your credentials on the list of authorised users. Help look for my glasses.'], 401);
        }

        return $next($request);
    }
}
