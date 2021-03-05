<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PointController extends Controller
{
    public function showpoint(Request $request){
        $response = explode(' ', $request->header('Authorization'));
        $profile = User::where('remember_token', $response[1])->first();

        return $profile->point;
    }

    public function trainingpoint(Request $request, $point){
        $response = explode(' ', $request->header('Authorization'));
        $profile = User::where('remember_token', $response[1])->first();
        $nowpoint = $profile->point;
        $reqpoint = $request->point;

        $newpoint = $nowpoint + $reqpoint;

        $update = $profile->update([
            'point' => $newpoint
        ]);

        if($update){
            return response()->json([
                'status' => 'succes',
                'point' => $newpoint
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'profile' => $nowpoint
        ], 400);
    }
}
