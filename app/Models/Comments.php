<?php
/**
 * Created by PhpStorm.
 * User: Ayomide
 * Date: 1/23/2019
 * Time: 10:15 PM
 */

namespace Livestock247\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Livestock247\Constants\Database;

class Comments extends Model
{
    protected $table = Database::COMMENT;
    public function user()
    {
        return $this->belongsTo('Livestock247\User', 'user_id');
    }

    public function livestock()
    {
        return $this->belongsTo('Livestock247\Models\Invoice', 'invoice_id');
    }

    public function createComment($data,$invoice_id,$id,$user_type)
    {
        $comment = new Comments();
        $comment->user_id = $id;
        $comment->invoice_id = $invoice_id;
        $comment->user_type = $user_type;
        $comment->comment = $data['comment'];
        $comment->save();

        return $comment;
    }

    //===================== get all invoice comment by invoice id
    public function getAllInvoiceCommentById($id)
    {
        return DB::table( Database::COMMENT)->where('invoice_id', $id)->get();
    }
}