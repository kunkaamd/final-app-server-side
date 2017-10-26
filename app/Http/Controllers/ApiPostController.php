<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;
class ApiPostController extends Controller
{
    public function getPost(Request $request,$id){
      $post = Post::with('comment.user')->where('id','=',$id)->get();
      return response()->json([
          'status'=> 200,
          'message'=> 'successfully',
          'data'=>$post
      ]);
    }
    public function getPostsOfUser(Request $request,$id){
      $posts = Post::select('id','title','image','rate','created_at','user_id')->where('user_id','=',$id)->with('user')->get();
      return response()->json([
          'status'=> 200,
          'message'=> 'successfully',
          'data'=>$posts
      ]);
    }
    public function getPostsOfSeries(Request $request,$id){
      $posts = Post::select('id','title','image','rate','user_id')->where('series_id','=',$id)->with('user')->get();
      return response()->json([
          'status'=> 200,
          'message'=> 'successfully',
          'data'=>$posts
      ]);
    }
    public function getManyPost(Request $request){
      $posts = Post::select('id','title','image','rate','user_id')->with('user')->get();
      return response()->json([
          'status'=> 200,
          'message'=> 'successfully',
          'data'=>$posts
      ]);
    }
    public function createPost(Request $request){
      // write photo and get url
      $url ="";
      if($request->hasFile('image')){
        $file = $request->file('image');
        try{
          $url = Storage::disk('uploads')->putFile('',$file,'public');
        }catch(\Exception $e){
            return response()->json(['error'=> `Can't upload image`],400);
        }
      }
      //save
      $post = new Post;
      $post->title = $request->title;
      $post->image = $url;
      $post->content = $request->content;
      $post->source = $request->source;
      $post->published = 'no';
      $post->user_id = $request->get('user')->id;
      $post->save();
      return response()->json('Create post successfully');
    }
    public function publishedOn(Request $request){
      $post = Post::find($request->id);
      $post->published = "yes";
      $post->save();
      return response()->json('Successfully');
    }
}
