<?php

namespace Livestock247\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;

class Controller extends BaseController
{
    /**
     * Construct for BaseController
     * @param $services
     */
    public function __construct()
    {

    }

    /**
     * Get the page number for pagination
     *
     * @return int
     */
    public function getPage()
    {
        $page = Request::instance()->get('page');

        return $page > 0 ? $page : 1;
    }

    /**
     * Get the page sort order for pagination
     *
     * @return string
     */
    public function getSort()
    {
        $sort = Request::instance()->get('sort');

        return !empty($sort) ? $sort : 'asc';
    }

    /**
     * Get the pagination limit
     *
     * @param int $defaultResults
     *
     * @return int
     */
    public function getLimit($defaultResults = 5)
    {
        $limit = Request::instance()->get('limit');

        if ($limit > 1000) {
            $limit = 1000;
        }

        return !empty($limit) ? $limit : $defaultResults;
    }

    /**
     * Send a success response if an API call was successful
     *
     * @param $data
     */
    public function sendSuccess($data)
    {
        $response = [
            'status' => 'success',
            'data'   => $data,
           
        ];

        return response()->json($response, 200);

    }

    /**
     * Send an error response if an API call failed
     *
     * @param      $message
     * @param      $error_code
     * @param int  $http_status_code
     * @param null $data
     */
    public function sendError($message, $error_code, $http_status_code = 200, $data = null)
    {
        if (is_array($message)) {
            $message = $message['message'];
        }

        $response = [
            'status'  => 'error',
            'message' => $message,
            'code'    => $error_code,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }


        return response()->json($response, $http_status_code);
    }
}

