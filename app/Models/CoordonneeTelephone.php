<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoordonneeTelephone extends Model
{
    use HasFactory;
    protected $table = 'coordonnee_telephone';
    protected $fillable = [
        'coordonnee_id',
        'telephone_id',
    ];
}
