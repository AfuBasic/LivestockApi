<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'v1','namespace'=>'\Livestock247\Http\Controllers'],function() use ($app)
{
    $app->post('/token', 'TokenController@index');
});

$app->group(['prefix' => 'v1', 'namespace' => '\Livestock247\Http\Controllers\Customers'], function() use ($app)
{
    $app->get('/welcome', function () use ($app) {
        return 'Hello world';
    });
});

$app->group(['prefix' => 'v1', 'middleware' => 'auth', 'namespace' => '\Livestock247\Http\Controllers\V1'], function() use ($app)
{
    //===================== Raise Order===================
    $app->get('/order/{id}', 'OrderController@getSingleOrder');

    //========== Generate Invoice ===================
    $app->post('/invoice', 'LivestockInvoiceController@saveInvoice');

    //========== chip ===================
    $app->post('/chip/{id}', 'LivestockInvoiceController@saveOrderChippingNumber');

    //--------------------- Approve Invoice -----------
    $app->post('/approve/chip/{id}', 'LivestockInvoiceController@approveInvoice');

    //==================== Invoice Comment ========================
    $app->post('/comment/{id}/{user_id}', 'CommentController@saveComment');
    $app->get('/comment/{id}', 'CommentController@getInvoiceComment');

    //==================== Customer Endpoints ==========================
    $app->post('/auth','AuthController@index');
    $app->post('/forgotpassword','AuthController@forgotPassword');
    $app->post('/resetpassword/{hash}','AuthController@resetPassword');
    $app->post('/customers','CustomerController@addCustomer');
    $app->get('/activate/{hash}','CustomerController@activate');
    $app->post('/verifycode','CustomerController@verifyCode');
    $app->get('/retrycode/{id}','CustomerController@resendCode');
    $app->get('/location', 'LocationController@showLocation');

    //=================== Payment Enpoint =================
    $app->post('/payment','PaymentController@pay');
    $app->get('/updatepayment/{id}/{status}','PaymentController@update');
    $app->get('/payment/{reference}','PaymentController@getPayment');

    //==================== Buyers Dashboard ===============================
    $app->get('/dashboard/{uid}','BuyersController@dashboard');	

     //===================== Get Breeds===================
    $app->get('/breeds', 'BreedListController@showBreed');

    //==================== Get Livestock ===============================
    $app->get('/livestocktype', 'LivestockTypeController@showLivestockType');

    //==================== Get stockweight ================================
    $app->get('/weight/{id}', 'LivestockWeight@getWeight');

   //==================== Get invoice ================================
    $app->get('/invoice/{id}', 'InvoiceController@getInvoice');

    //==================== Livestockweight ===============================
    $app->put('/weight','LivestockTypeController@updateWeight');

});