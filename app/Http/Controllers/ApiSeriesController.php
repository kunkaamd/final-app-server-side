<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Series;
use Illuminate\Support\Facades\Storage;
class ApiSeriesController extends Controller
{
  public function createSeries(Request $request){
    // write photo and get url
    $series = new Series;
    $series->user_id = $request->get('user')->id;
    $series->name = $request->name;
    $series->save();
    return response()->json('Create series successfully');
  }
  public function getSeriesOfUser(Request $request){
    $series = Series::select('id','name')->where('user_id','=',$request->get('user')->id)->get();
    return response()->json([
        'status'=> 200,
        'message'=> 'successfully',
        'data'=>$series
    ]);
  }
  public function getSeriesPopular(){
    $data = Series::select('id','name','postnumber','user_id','created_at')->orderBy('postnumber', 'desc')->with('user')->get();
    return response()->json([
        'status'=> 200,
        'message'=> 'successfully',
        'data'=> $data
    ]);
  }
  public function getAllSeries(){
    $data = Series::select('id','name')->get();
    return response()->json([
        'status'=> 200,
        'message'=> 'successfully',
        'data'=> $data
    ]);
  }


  public function getAllSeriesWithPost(){
    $data = Series::select('id','name')->get();
    $data->map(function ($item) {
        $item['post'] = $item->post()->select('title','id')->get();
        return $item;
    });
    return response()->json([
        'status'=> 200,
        'message'=> 'successfully',
        'data'=> $data
    ]);
  }
}
