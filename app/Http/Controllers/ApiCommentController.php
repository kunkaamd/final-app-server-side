<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
class ApiCommentController extends Controller
{
    public function createComment(Request $request,$postId){
      $comment = new Comment;
      $comment->comment = $request->comment;
      $comment->user_id = $request->get('user')->id;
      $comment->post_id = $postId;
      $comment->save();
      return response()->json('Add new comment successfully');
    }
}
