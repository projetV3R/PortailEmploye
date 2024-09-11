<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Usager;
use App\Http\Requests\UsagerRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsagersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fillable = Usager::all();
        return view('Auth.login', compact('fillable'));    
    }

    public function usagerindex()
    {
        $fillable = Usager::all();
        $usagers = Usager::all();
        return view('Auth.dashboard', compact('usagers','fillable'));
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        $reussi = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        //Log::debug(''.$reussi);
        if($reussi)
        {
            $reussi = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

            if($reussi)
            {
                return view('Auth.dashboard');    
            }
            else
            {
                return redirect()->route('login')->withErrors(['Informations invalides']);
            }
        }
    }
    public function logout (Request $request)
    {        
        Auth::logout();
        Session::flush();
        return redirect()->route('showLoginForm')->with("message",'Déconnexion réussi');
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
 /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
