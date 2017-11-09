<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test;
use Session;
use App\Tag;
use App\Post;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
class TestController extends Controller
{
    //
    public function index(){
    	$data = Test::all();
    	return $data;
    }
    public function test(Request $request){
      $input = 'java';
      $post = Post::find(1);
      $id = Tag::select('id')->where('name',$input)->first();
      if($id === null){
        $post->tag()->create([
          'name' => $input,
        ]);
      }else{
        $post->tag()->attach($id->id);
      }
      return $id;
    }
}
