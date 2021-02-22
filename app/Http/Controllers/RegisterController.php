<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminAPI;
use App\Models\User;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'hondaid'     => 'required',
            'role'  => 'required',
            'namapic'    => 'required',
            'password' => 'required',
            'tempatlahir' => 'required',
            'tgllahir' => 'required',
            // 'foto' => 'required',
            'jabatan' => 'required',
            'status' => 'required',
            'dealer' => 'required',
            // 'level' => 'required',
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
            // $level = $request->class;
            

        $Adminauth = User::create([
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
                return ([
                    'hondaid'     => $hondaid,
                    'role'  => $role,
                    'namapic'    => $namapic,
                    'password' => $password,
                    'tempatlahir' => $tempatlahir,
                    'tgllahir' => $tgllahir,
                    'jabatan' => $jabatan,
                    'status' => $status,
                    'dealer' => $dealer,
                    'level' => 'basic',
                    'point' => 0

                ]);
            }
            return(['error' => 'Gagal daftar !']);
    }
}
