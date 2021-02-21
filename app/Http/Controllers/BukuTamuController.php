<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuTamu;

class BukuTamuController extends Controller
{
    public function upload_bukutamu(Request $request){
        $this->validate($request,[
            'gambar' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            // 'gambar' => 'required',
            'keterangan' => 'required',
        ]);
        $file = $request->file('gambar');
        $name = $file->getClientOriginalName();
        $namafile = time()."_".$file->getClientOriginalName();
        // $namafile = time()."_".$file;
        $path = 'gambar';
        $file->move($path,$namafile);
        $keterangan = $request->keterangan;


        $upload = BukuTamu::create([
            'gambar' => $namafile,
            'keterangan' => $request->keterangan
        ]);

        if($upload){
            return ([
                'gambar'     => $namafile,
                'keterangan'    => $keterangan
                // 'path'  =>  $path,$namafile
            ]);
        }
        return(['error' => 'Gagal upload !']);
    }
}
