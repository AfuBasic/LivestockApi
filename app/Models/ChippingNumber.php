<?php
/**
 * Created by PhpStorm.
 * User: Ayomide
 * Date: 1/24/2019
 * Time: 3:55 PM
 */

namespace Livestock247\Models;

use Illuminate\Database\Eloquent\Model;
use Livestock247\Constants\Constants;
use Livestock247\Constants\Database;

class ChippingNumber extends Model
{

    protected $table = Database::CHIPPING;

    public function saveChippingNumber($data,$id)
    {
        $chipIds = [];
        foreach ($data['chips'] as $chip){
            $chipmodel = new ChippingNumber();
            $chipmodel->uid = $data['user_id'];
            $chipmodel->invoice_id = $id;
            $chipmodel->chip_no = $chip->chip_no;
            $chipmodel->pole_no = $chip->pole_no;
            $chipmodel->status = Constants::STATUS_ENABLE_1;
            $chipmodel->save();
            $chipIds[] = $chipmodel->id;
        }
        return $chipIds;


    }
}