<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AdminAPI;

class AdminController extends Controller
{
    public function loginadmin(Request $request){
        $this->validate($request, [
            'hondaid'  => 'required',
            'password' => 'required',
        ]);
        $hondaid= $request->hondaid;
        $password = $request->password;

        $token = Str::random(60);
        $api_token = hash('sha256', $token);
        
        $admin = AdminAPI::where([['hondaid', '=', $hondaid], ['password', '=', $password]])->first();
        
        if(!$admin)
            return response()->json([
                'status'  => 'error',
                'message' => 'User not found'
            ], 400);
        $api = $admin->update([
            'remember_token' => $api_token
        ]);
        $responseData = [
            'status' => 'succes',
            'user' => $admin,
            'api_token' => $api_token
        ];
        return ($responseData);
        
    }
    
    public function adduser(Request $request){
        $this->validate($request, [
            'hondaid'     => 'required',
            'role'  => 'required',
            'namapic'    => 'required',
            'password' => 'required',
            'tempatlahir' => 'required',
            'tgllahir' => 'required',
            'jabatan' => 'required',
            'status' => 'required',
            'dealer' => 'required',
        ]);
            $hondaid = $request->hondaid;
            $role = $request->role;
            $namapic= $request->namapic;
            $password = $request->password;
            $tempatlahir = $request->tempatlahir;
            $tgllahir = $request->tgllahir;
            $jabatan = $request->jabatan;
            $status = $request->status;
            $dealer = $request->dealer;            

        $Adminauth = AdminAPI::create([
            'hondaid'     => $request->hondaid,
            'role' => $request->role,
            'namapic'    => $request->namapic,
            'password' => $request->password,
            'tempatlahir' => $request->tempatlahir,
            'tgllahir' => $request->tgllahir,
            'jabatan' => $request->jabatan,
            'status' => $request->status,
            'dealer' => $request->dealer,
            'level' => 'basic',
            'point' => 0

        ]);
            if($Adminauth){
               return AdminAPI::where('hondaid', $hondaid)->first();
            }
            return(['error' => 'Gagal tambah akun !']);
    }

    public function edituser(request $request, $hondaid){
        $namapic= $request->namapic;
        $tempatlahir = $request->tempatlahir;
        $tgllahir = $request->tgllahir;
        $jabatan = $request->jabatan;
        $status = $request->status;
        $dealer = $request->dealer;
        $level = $request->level;
        $point = $request->point;

        $update = AdminAPI::find($hondaid);
        $update->namapic = $namapic;
        $update->tempatlahir = $tempatlahir;
        $update->jabatan = $jabatan;
        $update->status = $status;
        $update->dealer = $dealer;
        $update->level = $level;
        $update->point = $point;
        $update->save();

        if($update){
        return AdminAPI::where('hondaid', $hondaid)->first();
        }
        return(['error' => 'Gagal update profile !']);
    }

    public function deleteuser($hondaid){
        $role = AdminAPI::select('role')->where('hondaid', $hondaid)->get();
        if($role != 'super admin'){
            $user = AdminAPI::find($hondaid);
            $user->delete();
            return response()->json([
                'status' => 'succes',
                'message' => 'Berhasil Hapus Akun !'
            ], 200);
        }
        else if($role == 'admin'){
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak bisa hapus'
            ], 400);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Level anda bukan super admin'
            ], 400);
        }
    }
}
