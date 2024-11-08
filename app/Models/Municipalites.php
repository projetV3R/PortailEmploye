<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipalites extends Model
{
    use HasFactory;
    protected $table = 'municipalites';
    
    protected $guarded = ['*'];
}
