<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitsServices extends Model
{
    use HasFactory;
    protected $table = 'produits_services';
    
    protected $guarded = ['*'];
    public function fichesFournisseurs()
    {
        return $this->belongsToMany(
            FicheFournisseur::class,
            'produit_service_fiche_fournisseur', 
            'produit_service_id',               
            'fiche_fournisseur_id'             
        );
    }
    
}
