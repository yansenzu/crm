<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;

class SoalController extends Controller
{
    public function postsoal(Request $request){
        $this->validate($request, [
            'soal' => 'required',
            'kuncijawaban' => 'kuncijawaban'
        ]);
        
        $soal = Soal::create([
            'soal' => $request->soal,
            'kuncijawaban' => $request->kuncijawaban
        ]);

        if($soal){
            
        }
    }
}
