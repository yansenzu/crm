<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Str;
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
            'tempatlahir' => 'required',
            'tgllahir' => 'required',
            'jabatan' => 'required',
            'dealer' => 'required',
        ]);

        $update = $profile->update([
            'namapic' => $request->namapic,
            'tempatlahir' => $request->tempatlahir,
            'tgllahir' => $request->tgllahir,
            'jabatan' => $request->jabatan,
            'dealer' => $request->dealer
        ]);

        if($update){
            return response()->json([
                'status'  => 'succes',
                'message' => 'Success to update password !',
                'profile' => $profile
            ]);
        }
        return response()->json([
            'status'  => 'error',
            'message' => 'Failed to update password !',
            'profile' => $profile
        ]);
    }

    public function uploadimmage(request $request, $hondaid){
        // $response = explode(' ', $request->header('Authorization'));
        // $profile = User::where('remember_token', $response[1])->first();

        $profile = User::where('hondaid', $hondaid)->first();
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

    public function changeAvatar(Request $request) {
        $user_data = $request->user_data;
        $id = $user_data->hondaid;
        $file = $request->file('file');
        $type = 'images';
        $path = '/profile';
        $resize = TRUE;
        $resize_mode = 'fit';
        $rasio = ['width' => 480, 'height' => 480];
        $hasFile = $request->hasFile('file');

        if(!$hasFile) return $this->responseError($file, 'No selected files!');
        if(!$file->isValid()) return $this->responseError($file, 'Failed to Upload, please check your File!');
        $user = User::where('hondaid', $id)->first();

        $name = 'profile-'. Str::random(10) . '_' . $user_data->hondaid . '.' .$file->getClientOriginalExtension();
        
        $config = [
            'file' => $file,
            'type' => $type,
            'path' => $path,
            'name' => $name,
            'resize' => $resize,
            'rasio' => $rasio,
            'resize_mode' => 'fit'
        ];
        
        $user = $user_data;

        //Checking status user avaible
        if(!$user) return $this->responseError($user, 'Account not found, please contact Admin to report this problem!');

        $upload = $this->uploadFiles($config);
        if(!$upload) return $this->responseError($file, 'Failed to upload file, please check your upload file!');

        //delete last file & replaced the latest one
        if($user->photo) $this->deleteFile($upload['savepath'] . $user->photo);
        $update = $user->update([
            'foto' => $name
        ]);

        //Handle When Failed Uploaded!
        if(!$update) return $this->responseError($update, 'Failed to update account, please try again!');

        return $this->responseSuccess($user, 'Upload Successfully!');        
    }



}
