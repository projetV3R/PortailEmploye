<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FicheFournisseur;
use App\Models\ParametreSysteme;
use App\Models\Coordonnee;
use App\Models\Municipalites;

class FiltreController extends Controller
{

public function getVillesByRegions(Request $request)
{
    $regions = $request->input('regions', []);

    $query = Coordonnee::query();


    $query->whereHas('ficheFournisseur', function ($q) {
        $q->where('etat', '!=', 'désactivé');
    });

 
    if (!empty($regions)) {
        $query->whereIn('region_administrative', $regions);
    }

    $villes = $query->distinct()->pluck('ville');

    return response()->json(['villesDisponibles' => $villes]);
}

    
}
