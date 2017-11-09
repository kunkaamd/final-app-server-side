<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Series;
use Illuminate\Support\Facades\Storage;
class ApiPostController extends Controller
{
    public function getPost(Request $request,$id){
      $post = Post::with('comment.user')->where('id','=',$id)->get();
      $post[0]->view_count += 1;
      $post[0]->save();
      return response()->json([
          'status'=> 200,
          'message'=> 'successfully',
          'data'=>$post
      ]);
    }
    public function getPostsOfUser(Request $request,$id){
      $posts = Post::select('id','title','image','view_count','created_at','user_id')->where('published','=','yes')->where('user_id','=',$id)->with(['user','tag'])->get();
      return response()->json([
          'status'=> 200,
          'message'=> 'successfully',
          'data'=>$posts
      ]);
    }
    public function getPostNotPublished(){
      $posts = Post::select('id','title','image','rate','user_id')->where('published','=','no')->with('user')->get();
      return response()->json([
          'status'=> 200,
          'message'=> 'successfully',
          'data'=>$posts
      ]);
    }
    public function getPostsOfSeries(Request $request,$id){
      $posts = Post::select('id','title','image','rate','user_id')->where('published','=','yes')->where('series_id','=',$id)->with('user')->get();
      return response()->json([
          'status'=> 200,
          'message'=> 'successfully',
          'data'=>$posts
      ]);
    }
    public function getManyPost(Request $request){
      $posts = Post::select('id','title','image','rate','user_id')->where('published','=','yes')->with(['user','tag'])->get();
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
      if($request->has('series_id')){
        $post->series_id = $request->series_id;
        $series = Series::find($request->series_id);
        $series->postnumber+=1;
        $series->save();
      }
      $post->published = 'no';
      $post->view_count = '0';
      $post->user_id = $request->get('user')->id;
      $post->save();
      $this->addTag($post->id,$request->tag);
      return response()->json('Create post successfully');
    }
    private function addTag($idpost,$tags){
      if($tags != null){
        $post = Post::find($idpost);
        $arrayTag = explode(',', $tags);
        foreach ($arrayTag as $tag) {
          $id = Tag::select('id')->where('name',$tag)->first();
          if($id === null){
            $post->tag()->save(new Tag(['name' => $tag]));
          }else{
            $post->tag()->attach($id->id);
          }
        }
      }
    }
    public function publishedOn(Request $request,$id){
      $post = Post::find($id);
      $post->published = "yes";
      $post->save();
      return response()->json('Successfully');
    }
    public function deletePost(Request $request,$id){
      $post = Post::find($id);
      $post->delete();
      return response()->json('Successfully');
    }
}
