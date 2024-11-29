<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licence extends Model
{
    use HasFactory;
    protected $table = 'licences';
    protected $fillable = [
        'numero_licence_rbq',
        'statut',
        'type_licence',
        'fiche_fournisseur_id'
    ];


    public function ficheFournisseur()
    {
        return $this->belongsTo(FicheFournisseur::class);
    }
    public function sousCategories()
    {
        return $this->hasMany(SousCategorieLicence::class);
    }
    public function sousCategoriess()
    {
        return $this->belongsToMany(SousCategorie::class, 'sous_categorie_licence', 'licence_id', 'sous_categorie_id');
    }
}
