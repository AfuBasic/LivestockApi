<?php
/**
 * Created by PhpStorm.
 * User: akinyele.olubodun
 * Date: 30/04/2016
 * Time: 1:38 AM
 */

namespace Livestock247\Constants;


class Constants
{
    //Environment Variable
    const LOCAL = 'local';
    const STAGING = 'staging';
    const PRODUCTION = 'production';

    const SUCCESS = 'success';
    const FAILED = 'failed';
    const PENDING = 'pending';
    const MAIL_SENT_SUCCESS = 'Mail Successfully Sent';
    const PASSWORD_RESET_SUCCESS = 'Password has been reset successfully';
    const REGISTRATION_SUCCESS = 'Registration is successful';
    const ACTIVATION_SUCCESS = 'Activation is successful';
    const STATUS_ENABLED = 'enabled';
    const PAYMENT_UPDATE_SUCCESS = 'Payment has been updated successfully';
    const USER_TYPE_BUYER = 'buyer';
    const MALE = 'male';
    const FEMALE = 'female';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const INVOICE_CHAR_LENGHT = 9;
    const STATUS_ENABLE_1 = 1;
    const MESSAGE_VERIFICATION_EXPIRY = 24;
    const RESET_UNUSED = 0;
    const RESET_USED = 1;
    const TRANSACTION_ID_LENGTH = 15;
    const PAYMENT_PENDING = 0;
    const PAYMENT_SUCCESSFUL = 1;
    const PAYMENT_FAILED = 2;
    const MALE_KEY = 1;
    const FEMALE_KEY = 2;
}