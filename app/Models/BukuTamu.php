<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
    use HasFactory;
    protected $table = 'buku_tamu';
    protected $fillable = ['gambar', 'keterangan'];
}
