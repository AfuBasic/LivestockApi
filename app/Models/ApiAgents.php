<?php
/**
 * Created by PhpStorm.
 * User: akinyele.olubodun
 * Date: 23/04/2016
 * Time: 5:46 AM
 */

namespace Livestock247\Models;

use Livestock247\Constants\Constants;
use Livestock247\Constants\Database;


class ApiAgents extends BaseModel
{
    /**
     * @var   string
     */
    protected $table = Database::API_AGENTS;
    public static function getMerchantIdByApiToken($api_token)
    {
        return ApiAgents::where('api_token', $api_token)
                        ->where('status', Constants::STATUS_ENABLED)
                        ->pluck('agent_id')
                        ->first();
    }
}