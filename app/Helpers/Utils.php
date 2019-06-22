<?php
/**
 * Created by PhpStorm.
 * User: Ayomide
 * Date: 1/25/2019
 * Time: 5:10 PM
 */

namespace Livestock247\Helpers;

use Livestock247\Models\Invoice;

class Utils
{
    public static function generateUniqueInvoiceNo($requestId, $seed)
    {
        //hash the requestId with md5
        $md5Hash = md5($requestId);

        //convert hex string to decimal
        $dec = strval(substr(number_format(hexdec($md5Hash), 2, '.', ''), 0, 32));

        $indices = self::uniqueRandomNumbersWithinRange(0, 31, $seed);
        $unique_reference = '';

        foreach ($indices as $index)
        {
            $unique_reference .= $dec[$index];
        }

        if (Invoice::where('invoice_no', '=', $unique_reference)->exists()) {
            return self::generateUniqueInvoiceNo($requestId, $seed);
        }

        return $unique_reference;
    }

    public static function uniqueRandomNumbersWithinRange($min, $max, $seed)
    {
        $numbers = range($min, $max);
        shuffle($numbers);

        return array_slice($numbers, 0, $seed);
    }

    public static function getTimeDifference($start_time, $stop_time)
    {
        return ceil(($stop_time - $start_time) / (60 * 60));
    }

    public static function get3DESencryptioncode($data, $secret) {

        $key = md5(utf8_encode($secret), true);

        //Take first 8 bytes of $key and append them to the end of $key.
        $key .= substr($key, 0, 8);

        //Pad for PKCS7
        $blockSize = @mcrypt_get_block_size('tripledes', 'ecb');
        $len = strlen($data);
        $pad = $blockSize - ($len % $blockSize);
        $data .= str_repeat(chr($pad), $pad);

        //Encrypt data
        $encData = @mcrypt_encrypt('tripledes', $key, $data, 'ecb');
        return base64_encode($encData);
    }
}