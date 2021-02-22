<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminAPI;
use App\Models\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request){
        $this->validate($request, [
            'hondaid'    => 'required',
            'password' => 'required'
        ]);
        $hondaid= $request->hondaid;
        $password = $request->password;
        $rand = Str::random(40);
        $api_token = base64_encode($rand);
        if(!$hondaid || !$password) 
        return response()->json([
            'status' => 'error',
            'message' => 'Password atau Honda ID Tidak boleh kosong !'
        ], 200);
        $user = User::where([['hondaid', '=', $hondaid], ['password', '=', $password]])->first();
        if(!$user) 
        return response()->json([
            'status' => 'error',
            'message' => 'Akun tidak ditemukan !'
        ], 200);

        $gen_api = $user->update([
            'remember_token' => $api_token
        ]);
        $responseData = [
            'status' => 'succes',
            'user' => $user,
            'api_token' => $api_token
        ];
        return ($responseData);

    }
}
