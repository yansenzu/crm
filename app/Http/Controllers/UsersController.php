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
        $this->validate($request, [
            'hondaid'     => 'required',
            'namapic'    => 'required',
            'password' => 'required',
            'tempatlahir' => 'required',
            'tgllahir' => 'required',
            'jabatan' => 'required',
            'status' => 'required',
            'dealer' => 'required',
            'class' => 'required',
        ]);

        $hondaid = $request->hondaid;
        $namapic= $request->namapic;
        $password = $request->password;
        $tempatlahir = $request->tempatlahir;
        $tgllahir = $request->tgllahir;
        $jabatan = $request->jabatan;
        $status = $request->status;
        $dealer = $request->dealer;
        $class = $request->class;

        $update = User::update([
            'hondaid'     => $request->hondaid,
            'namapic'    => $request->namapic,
            'password' => $request->password,
            'tempatlahir' => $request->tempatlahir,
            'tgllahir' => $request->tgllahir,
            'jabatan' => $request->jabatan,
            'status' => $request->status,
            'dealer' => $request->dealer,
            'class' => $request->class
        ]);
            if($Adminauth){
                return ([
                    'hondaid'     => $hondaid,
                    'namapic'    => $namapic,
                    'password' => $password,
                    'tempatlahir' => $tempatlahir,
                    'tgllahir' => $tgllahir,
                    'jabatan' => $jabatan,
                    'status' => $status,
                    'dealer' => $dealer,
                    'class' => $class,

                ]);
            }
            return(['error' => 'Gagal daftar !']);
    }

    public function deleteuser(request $request, $hondaid){
        $idsession = $request->idsession;
        $role1 = User::select('role')->where('hondaid', $idsession)->get();
        $role2 = User::select('role')->where('hondaid', $hondaid)->get();
        return $role2;
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
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Level anda bukan super admin'
            ], 200);
        }
    }
}
