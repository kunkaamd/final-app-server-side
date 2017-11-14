<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class ApiTagController extends Controller
{
    public function getPopuparTag(){
      $data = DB::select('SELECT tag.id,tag.name,temp.postnumber FROM tag INNER JOIN (SELECT COUNT(*) as postnumber,tag_id FROM posttag GROUP BY tag_id ORDER BY postnumber DESC LIMIT 15) AS temp ON temp.tag_id = tag.id');
      return response()->json([
          'status'=> 200,
          'message'=> 'successfully',
          'data'=> $data
      ]);
    }
    public function getAllTag(){
      //$data = DB::select('SELECT tag.id,tag.name,temp.numberpost FROM `tag` LEFT JOIN (SELECT COUNT(*) AS numberpost,tag_id FROM posttag GROUP BY tag_id) AS temp ON temp.tag_id = tag.id');
      $data = DB::table('tag')->leftJoin(DB::raw('(SELECT COUNT(*) AS numberpost,tag_id FROM posttag GROUP BY tag_id) AS temp'),'temp.tag_id','=','tag.id')->paginate(9);
      return response()->json([
          'status'=> 200,
          'message'=> 'successfully',
          'data'=> $data
      ]);
    }
}
