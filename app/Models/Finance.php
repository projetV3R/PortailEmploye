<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;
    protected $table = 'finances';
    protected $fillable = [
        'numero_tps',
        'numero_tvq',
        'condition_paiement',
        'devise',
        'mode_communication',
        'fiche_fournisseur_id',
    ];
    public function ficheFournisseur()
    {
        return $this->belongsTo(FicheFournisseur::class);
    }
}
