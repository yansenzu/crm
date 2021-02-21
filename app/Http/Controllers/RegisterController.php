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
            

        $Adminauth = User::create([
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
