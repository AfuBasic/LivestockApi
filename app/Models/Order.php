<?php
/**
 * Created by PhpStorm.
 * User: Ayomide
 * Date: 1/23/2019
 * Time: 2:23 PM
 */

namespace Livestock247\Models;

use Illuminate\Database\Eloquent\Model;
use Livestock247\Constants\Constants;
use Livestock247\Constants\Database;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'user_id', 'order_date', 'order_no', 'delivery_date', 'delivery_period', 'delivery_location', 'tp_type',
        'address', 'status', 'orders',
    ];

    protected $table= Database::ORDER;


    public function user()
    {
        return $this->belongsTo('Livestock247\User');
    }

    public function createOrder($data,$invoice,$user_id)
    {

        $qty = 0;
        foreach($data['orders'] as $role){
            $order = new Order();
            $order->uid = $user_id;
            $order->order_date = date('Y-m-d');
            $order->invoice_id = $invoice;
            $order->livestock_type = $role->livestock_type;
            $order->weight = $role->weight;
            $order->sex = $role->sex;
            $order->breed = $role->breed;
            $order->address = $data['address'];
            $order->delivery_date = $data['delivery_date'];
            $order->delivery_period = $data['delivery_period'];
            $order->delivery_location = $data['delivery_location'];
            $order->qty = $role->qty;
            $order->address = $data['address'];
            $order->save();
            $qty += $role->qty;
        }
        if($qty != 0){
           return $qty;
        }
        return false;
    }

    public function getSingleOrder($id)
    {
        return Order::where('id',$id)->first();
    }

    public function getAllUserOrder($id)
    {
        return Order::where('uid',$id)->get();
    }




}