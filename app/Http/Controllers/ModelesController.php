<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modele;
use App\Http\Requests\ModeleRequest;

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
    public function update(ModeleRequest $request, $id)
    {
        $validatedData = $request->validated();
       
        $modele = Modele::findOrFail($id);
    
     
        $modele->objet = $validatedData['objet'];
        $modele->body = $validatedData['body'];
        $modele->save();
    
        return response()->json(['message' => 'Modèle mis à jour avec succès'], 200);
    }
    
}
