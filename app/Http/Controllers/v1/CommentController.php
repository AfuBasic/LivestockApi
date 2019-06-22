<?php
/**
 * Created by PhpStorm.
 * User: Ayomide
 * Date: 1/23/2019
 * Time: 10:31 PM
 */

namespace Livestock247\Http\Controllers\v1;

use Livestock247\Helpers\Validate;
use Livestock247\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Livestock247\Constants\ResponseCodes;
use Livestock247\Constants\ResponseMessages;
use Livestock247\Models\Comments;
use Livestock247\Constants\Constants;

class CommentController extends Controller
{
    public function saveComment($id,$user_id)
    {
        $req = Request::Instance();
        $data = $req->getContent();
        $comment = new Comments();
        $data = (array) json_decode($data);

        if ($data) {
            $validator = Validate::validateComment($data);
            if (!$validator->fails()) {
                $checkcomment = $comment->createComment($data, $id , $user_id,Constants::USER_TYPE_BUYER);
                if ($checkcomment) {
                    return $this->sendSuccess(['invoice_id' => $id, 'comment' => $checkcomment]);
                }
            }
            return $this->sendError($validator->errors(), 200);
        }
        return $this->sendError(['message' => ResponseMessages::INVALID_PARAMS, ResponseCodes::INVALID_PARAMS], 200);
    }

    //====================== get All invoice comment
    public function getInvoiceComment($id)
    {
        $comment = new Comments();
        $comment = $comment->getAllInvoiceCommentById($id);
        if (!empty($comment)) {
            return $this->sendSuccess(['comments' => $comment]);
        }
        return $this->sendError(['message' => ResponseMessages::RESULT_NOT_FOUND, ResponseCodes::RESULT_NOT_FOUND],200);
    }
}