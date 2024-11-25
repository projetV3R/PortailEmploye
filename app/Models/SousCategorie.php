<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousCategorie extends Model
{
    use HasFactory;
    protected $table = 'sous_categories';
    
    protected $guarded = ['*'];

    public function licences()
{
    return $this->belongsToMany(
        Licence::class,
        'sous_categorie_licence', 
        'sous_categorie_id', 
        'licence_id' 
    );
}

}
