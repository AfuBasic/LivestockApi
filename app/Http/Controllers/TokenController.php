<?php

namespace Livestock247\Http\Controllers;

use Livestock247\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Livestock247\Models\ApiAgents;

class TokenController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'agent_id' => 'required|unique:tbl_api_agent'
        ]);
        $token          = md5(rand(111111,999999));
        $private_key    = hash('sha256',rand(111111,999999));
        $public_key     = strtolower(hash('sha512', ($token . $private_key)));
        $apiAgent = new ApiAgents();
        $apiAgent->api_token    = $token;
        $apiAgent->private_key  = $private_key;
        $apiAgent->status       = 'enabled';
        $apiAgent->name         = $request->input('name');
        $apiAgent->agent_id     = $request->input('agent_id');

        $apiAgent->save();
        return response([
            'token'         => $token,
            'publickey'     => $public_key
        ]);
    }
}

