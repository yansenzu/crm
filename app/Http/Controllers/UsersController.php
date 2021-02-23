<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminAPI;
use App\Models\User;


class UsersController extends Controller
{

    public function index(){
        $users = User::all();
        return $users;
    }

    public function usersbyid(request $request, $hondaid){
        return User::find($hondaid);
    }

    public function updateuser(request $request, $hondaid){
        $namapic= $request->namapic;
        $password = $request->password;
        $tempatlahir = $request->tempatlahir;
        $tgllahir = $request->tgllahir;
        $jabatan = $request->jabatan;
        $status = $request->status;
        $dealer = $request->dealer;
        $level = $request->level;
        $point = $request->point;

        $update = User::find($hondaid);
        $update->namapic = $namapic;
        $update->password = $password;
        $update->tempatlahir = $tempatlahir;
        $update->jabatan = $jabatan;
        $update->status = $status;
        $update->dealer = $dealer;
        $update->level = $level;
        $update->point = $point;
        $update->save();

        if($update){
        return User::where('hondaid', $hondaid)->first();
        }
        return(['error' => 'Gagal update profile !']);
    }

    public function deleteuser($hondaid){
        $role = User::select('role')->where('hondaid', $hondaid)->get();
        if($role != 'super admin'){
            $user = User::find($hondaid);
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
