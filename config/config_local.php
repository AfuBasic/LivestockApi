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
        'site_logo' => 'https://livestock247.com/logo-300x116.png',
        'sana_pay_staging' => 'https://stagingptpp.saanapay.com/Api/Merchant/',
        'sana_pay_requery' => 'https://stagingptpp.saanapay.com/api/requerytransaction'
        'e3des' => 'GZSIxsh42um6GgzgKZ6F',
        'authorization' => 'MjAxODExMjEzNDIzNjg3NDIwMTgxMTIx',
        'test_merchant_service_id' => 20209,
        'merchant_code' = 687420181121,
        'merchant_key' = 201811213423,
    ],

    'notification' => [
        'sms' => [
            'url' => '',
            'username' => '',
            'password' => ''
        ],
        'email' => [
            'api_key' => '',
            'domain' => '',
            'from' => ''
        ],
    ],

    'invoice' => [
        'recent' => 10
    ]
];