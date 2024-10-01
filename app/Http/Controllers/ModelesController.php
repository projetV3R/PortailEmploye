<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modele;

class ModelesController extends Controller
{
  
    public function index()
    {
    
        $modeles = Modele::all();

     
        return response()->json($modeles);
    }
    public function show($id)
    {
       
        $modele = Modele::findOrFail($id);
    
       
        return response()->json($modele);
    }
    public function update(Request $request, $id)
    {
      
        $request->validate([
            'objet' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Trouver le modèle à mettre à jour
        $modele = Modele::findOrFail($id);

        // Mettre à jour les champs objet et body
        $modele->objet = $request->input('objet');
        $modele->body = $request->input('body');
        $modele->save();


        return response()->json(['message' => 'Modèle mis à jour avec succès'], 200);
    }
}
