<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsagerRequest;
use Auth;
use Log;

use App\Models\Usager;
use Illuminate\Support\Facades\Hash;

class UsagerController extends Controller
{
    
    public function index()
    {
        // TODO PAGINATION
    }

    public function store(UsagerRequest $request)
    {
        $validatedData = $request->validated();
        try {
            Usager::create([
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),// TODO retirer quand le sso vas etre la
                'nom' => $validatedData['nom'],
                'prenom' => $validatedData['prenom'],
                'role' => $validatedData['role'],
            ]);
    
            return redirect()->back()->with('success', 'Utilisateur ajouté avec succès!');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création d\'un utilisateur : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'ajout de l\'utilisateur.');
        }
    }

}
