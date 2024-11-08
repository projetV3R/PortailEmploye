<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitsServices extends Model
{
    use HasFactory;
    protected $table = 'produits_services';
    
    protected $guarded = ['*'];
}
