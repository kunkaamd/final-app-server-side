<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Series;
use App\Post;
class SeriesController extends Controller
{
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
