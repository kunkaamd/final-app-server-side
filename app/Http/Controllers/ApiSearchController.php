<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Series;
use App\Tag;
class ApiSearchController extends Controller
{
    public function search(Request $request,$key){
      $key="%".$key."%";
      $post = Post::select('id','title','image','view_count','created_at','user_id')->where('title','like',$key)->with(['user','tag'])->get();
      $series = Series::where('name','like',$key)->with('user')->get();
      $user = User::where('name','like',$key)->get();
      $tag = Tag::where('name','like',$key)->get();
      return response()->json([
          'status'=> 200,
          'message'=> 'successfully',
          'data'=>['user' => $user,'series' => $series,'post' => $post,'tag' => $tag],
      ]);
    }
}
