<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function insertvideo(request $request){

        $this->validate($request,[
            'videourl'    => 'required',
            'description' => 'required',
            'title'       => 'required'
        ]);

        $insert = Video::create([
            'videourl'     => $request->videourl,
            'description' => $request->description,
            'title'    => $request->title,
            ]);
        
        if($insert){
            return response()->json([
                'status'   => 'succes',
                'message'  => 'Success to insert video !',
                'video'    => $insert
            ]);
            return response()->json([
                'status'   => 'error',
                'message'  => 'Failed to insert video !',
                'video'    => 'null'
            ]);
        }
        
    }
}
