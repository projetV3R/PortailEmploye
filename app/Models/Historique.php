<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;

    protected $table = 'historiques';

    protected $fillable = [
        'table_name',
        'author',
        'action',
        'old_values',
        'new_values',
        'fiche_fournisseur_id',
    ];

  
    public function getOldValuesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getNewValuesAttribute($value)
    {
        return json_decode($value, true);
    }


    public function ficheFournisseur()
    {
        return $this->belongsTo(FicheFournisseur::class, 'fiche_fournisseur_id');
    }
}
