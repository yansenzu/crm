<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAPI extends Model
{
    use HasFactory;

    protected $primaryKey = 'hondaid';
    protected $table = 'users';
    protected $guarded = '';
    
}
