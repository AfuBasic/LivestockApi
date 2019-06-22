<?php
/**
 * Created by PhpStorm.
 * User: akinyele.olubodun
 * Date: 11/02/2017
 * Time: 5:39 AM
 */

namespace Livestock247\Constants;


class ResponseMessages
{
    const INVALID_PARAMS = 'Invalid parameters';
    const INVALID_AMOUNT = 'Invalid amount';
    const RESULT_NOT_FOUND = 'Record not found';
    const ORDER_NOT_APPROVED = 'Sorry the orders are yet to be approved by customer';
    const CHIP_SUCCESSFUL_MESSAGE = 'Chip number saved successfully';
    const APPROVE_ORDER_MESSAGE = 'Orders successfully approved';
    const INCOMPLETE_FORM = 'The submitted form is incomplete';
    const INVALID_LINK = 'The link has expired or invalid';
    const INVALID_CODE = 'The code you entered is invalid';
    const INVALID_CODE_USER = 'The user you supplied does not exist for the activation code';
    const INVALID_USER = 'User could not be found';
    const INVALID_LOGIN = 'Username or Password is invalid';
    const INVALID_PASSWORD = 'The specified password is incorrect';
    const INVALID_PAYMENT = 'Payment could not be found';
    const INVALID_PAYMENT_STATUS = 'Invalid Payment Status Supplied';
}