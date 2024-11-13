<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousCategorieLicence extends Model
{
    use HasFactory;
    protected $table = 'sous_categorie_licence';
    protected $fillable = [
        "licence_id",
        "sous_categorie_id",
    
    ];

    public function categorie()
    {
        return $this->belongsTo(SousCategorie::class, 'sous_categorie_id');
    }
}
