<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Image;
use File;

class UserController extends Controller
{
    public function getprofile(Request $request){

        $response = explode(' ', $request->header('Authorization'));
        $profile = User::where('remember_token', $response[1])->first();

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

    public function edituserprofile(Request $request){
        $response = explode(' ', $request->header('Authorization'));
        $profile = User::where('remember_token', $response[1])->first();

        $this->validate($request, [
            'namapic'    => 'required',
            'password' => 'required',
            'tempatlahir' => 'required',
            'tgllahir' => 'required',
            'jabatan' => 'required',
            'dealer' => 'required',
        ]);

        $update = $profile->update([
            'namapic' => $request->namapic,
            'password' => $request->password,
            'tempatlahir' => $request->tempatlahir,
            'tgllahir' => $request->tgllahir,
            'jabatan' => $request->jabatan,
            'dealer' => $request->dealer
        ]);

        if($update){
            return response()->json([
                'status'  => 'succes',
                'message' => 'Success to update profile !',
                'profile' => $profile
            ]);
        }
        return response()->json([
            'status'  => 'error',
            'message' => 'Failed to update profile !',
            'profile' => $profile
        ]);
    }

    public function uploadimmage(Request $request){
        $response = explode(' ', $request->header('Authorization'));
        $profile = User::where('remember_token', $response[1])->first();

        $this->validate($request, [
			'foto' => 'required|file|image|mimes:jpeg,png,jpg'
		]);

        $foto = $request->file('foto');
        $nama_foto = time()."_".$foto->getClientOriginalName();
        $path = 'profile';
		$foto->move($path,$nama_foto);

        $update = $profile->update([
            'foto' => $nama_foto
        ]);

        if($update){
            return response()->json([
                'status'  => 'succes',
                'message' => 'Success to upload immage',
                'foto'    => $nama_foto,
                'path'    => $path . '/' . $nama_foto
            ]);
        }
        return response()->json([
            'status'  => 'error',
            'message' => 'Failed to upload immage',
        ]);
    }
}
