<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrochureCarte extends Model
{
    use HasFactory;
    protected $table = 'brochures_cartes';
    protected $fillable = [
        'nom',
        'type_de_fichier',
        'chemin',
        'taille',
        'fiche_fournisseur_id'
    ];
}
