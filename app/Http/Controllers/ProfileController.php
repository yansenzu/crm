<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function getprofile(Request $request){

        $response = explode(' ', $request->header('Authorization'));
        $token = User::where('remember_token', $response[1])->first();

        if($profile){
            return response()->json([
                'status' => 'succes',
                'profile' => $profile
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'profile' => $profile
        ], 200);
    }
}
