<?php
/*
*  2016 Ogaranya
*
*  @author Akinyele Olubodun <info@ogaranya.com>
*  @copyright  2016 Ogaranya Team
*  International Registered Trademark & Property of Ogaranya Team
*/

return [

    'application' => [
        'sms_charges' => 500,
        'phone_charges' => 400,
        'bank_charges'  => 2000,
        'mtn_chip'  => 2000,
    ],

    'notification' => [
        'sms' => [
            'url' => '',
            'username' => '',
            'password' => env()
        ],
        'email' => [
            'api_key' => '',
            'domain' => '',
            'from' => ''
        ]
    ],

    'invoice' => [
        'recent' => 10
    ]
];