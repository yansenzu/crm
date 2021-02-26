<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminAPI;
use App\Models\User;

class PasswordController extends Controller
{
    public function updatepassword(request $request, $hondaid){
        $password = $request->password;

        $update = AdminAPI::find($hondaid);
        $update->password = $password;
        $update->save();

        if($update){
            return response()->json([
                'status'  => 'success',
                'message' => 'Succes to update password !'
            ]);
        }
        return response()->json([
            'status'  => 'success',
            'message' => 'Failed to update password !'
        ]);
    }

    public function updateuserpassword(request $request){
        $response = explode(' ', $request->header('Authorization'));
        $profile = User::where('remember_token', $response[1])->first();

        $this->validate($request, [
            'password' => 'required'
        ]);

        $update = $profile->update([
            'password' => $request->password
        ]);

        if($update){
            return response()->json([
                'status'  => 'succes',
                'message' => 'Success to update profile !',
                'password'=> $request->password,
                'profile' => $profile
            ]);
        }
        return response()->json([
            'status'  => 'error',
            'message' => 'Failed to update profile !',
            'profile' => $profile
        ]);
    }
}
