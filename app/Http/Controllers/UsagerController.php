<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsagerRequest;
use Auth;
use Log;

use App\Models\Usager;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
public function index()
{
    //TODO liste usagers
}

public function store (Request $request)
{
 
    $validatedData = $request->validated();

    Usager::create([
        'email' => $validatedData['email'],
        'motDePasse' => Hash::make($validatedData['motDePasse']),
        'nom' => $validatedData['nom'],
        'prenom' => $validatedData['prenom'],
        'role' => $validatedData['role'],
    ]);

    //TODO Try and catch 
}



}
