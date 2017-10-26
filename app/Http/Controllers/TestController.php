<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test;
use Session;
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
      if($request->hasFile('file')){
        $file = $request->file('file');
        try{
          $url = Storage::disk('uploads')->putFile('',$file,'public');
          error_log($url);
        }catch(\Exception $e){
            return response()->json(['error'=> $e->getMessage()]);
        }
      }
      return response()->json(['success'=>''.$url]);
    }
}
