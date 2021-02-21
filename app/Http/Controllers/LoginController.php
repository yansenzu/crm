<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminAPI;
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
        if(!$hondaid || !$password) return $this->responseError(NULL,  'Honda ID tidak boleh kosong!');
        $user = AdminAPI::where('hondaid', $hondaid)->first();
        if(!$user) return $this->responseError($user, 'Akun tidak ditemukan!', 404);

        $gen_api = $user->update([
            'remember_token' => $api_token
        ]);

        if(!$gen_api) return $this->responseError([
            'message' => 'API not generate!'
        ], 'Terjadi kesalahan');

        $responseData = [
            'user' => $user,
            'api_token' => $api_token
        ];
        // return $this->responseSuccess($responseData, 'Berhasil masuk!!', 200);
        return ($responseData);
    }
}
