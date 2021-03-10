<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\User;

class VideoController extends Controller
{
    public function insertvideo(request $request){

        $response = explode(' ', $request->header('Authorization'));
        $profile = User::where('remember_token', $response[1])->first();
        $index = count(array($profile));

        $this->validate($request,[
            'videourl'    => 'required',
            'description' => 'required',
            'title'       => 'required'
        ]);

        if($index == 1){
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
        }}
        return response()->json([
            'status'    => 'error',
            'message'   => 'You not login yet, please login first !'
        ]);
        
    }

    public function videobytype(Request $request){
        $response = explode(' ', $request->header('Authorization'));
        $profile = User::where('remember_token', $response[1])->first();
        $type = $profile->level;

        $video = Video::where('level', $type)->first();

        if($video){
            return response()->json([
                'status'    => 'success',
                'video'     => $video
            ]);
        }
        return response()->json([
            'status'    => 'error',
            'video'     => 'null'
        ]);

    }
}
