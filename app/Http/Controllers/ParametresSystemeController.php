<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParametreSysteme;
use App\Http\Requests\ParametreSystemeRequest;
class ParametresSystemeController extends Controller
{


    public function index()
    {    
        $emails = ParametreSysteme::whereIn('cle', [
            'email_approvisionnement',
            'finance_approvisionnement'
        ])->get()->pluck('valeur', 'cle');
    
        $numeriques = ParametreSysteme::whereIn('cle', [
            'taille_fichier',
            'mois_revision'
        ])->get()->pluck('valeur_numerique', 'cle');
     
        $parametres = $emails->merge($numeriques);
    
        return response()->json($parametres);
    }
    


    public function store(ParametreSystemeRequest $request)
    {
        
        $valeur = $request->valeur;
        $valeur_numerique = $request->valeur_numerique;

        ParametreSysteme::updateOrCreate(
            ['cle' => $request->cle],
            [
                'valeur' => $valeur ?? null,
                'valeur_numerique' => $valeur_numerique ?? null,
            ]
        );
    
        // Réponse JSON en cas de succès
        return response()->json(['message' => 'Paramètre enregistré avec succès!']);
    }
    
    
    

}
