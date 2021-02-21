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

    public function usersbyid(request $request, $id){
        return User::find($id);
    }

    public function updateuser(request $request, $id){
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

    
}
