<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitServiceFicheFournisseur extends Model
{
    use HasFactory;
    protected $table = 'produit_service_fiche_fournisseur';
    protected $fillable = [
        "produit_service_id",
        "fiche_fournisseur_id"
    ];
}
