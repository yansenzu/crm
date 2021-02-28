<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function uploadvide(request $request){
        $response = explode(' ', $request->header('Authorization'));
        $profile = User::where('remember_token', $response[1])->first();

        $this->validate([
            'urlvideo'    => 'required',
            'descryption' => 'required',
            'title'       => 'required'
        ]);

        
    }
}
