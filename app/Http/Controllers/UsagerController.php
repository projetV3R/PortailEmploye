<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Usager;
use App\Http\Requests\UsagerRequest;
use Illuminate\Support\Facades\Hash;


class UsagerController extends Controller
{
    
    public function index(Request $request)
    {
            $usagers = Usager::paginate(2); 
            return view('admin.admin', compact('usagers'))->render();
        
    }

    public function dashboard()
    {
        return view('Auth.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Le champ email est obligatoire.',
            // message different pour le mail sans le @
            'email.email' => 'Informations invalide.',
            'password.required' => 'Le champ mot de passe est obligatoire.',
            'password.password' => 'Informations invalide.',
        ]);
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');     
        }
    
        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ])->withInput($request->only('email'));
    }
    

    public function logout (Request $request)
    {        
        Auth::logout();
        Session::flush();
        return redirect()->route('login')->with("message",'Déconnexion réussi');
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
    public function update(Request $request)
    {
        Log::debug('1');
        // Récupérer les données du formulaire
        $usagersData = $request->input('usagers');
    
        // Parcourir chaque utilisateur soumis dans le formulaire
        foreach ($usagersData as $usagerData) {
            // Validation des rôles
            $request->validate([
                'usagers.*.role' => 'required|in:admin,responsable,commis',
            ]);
    
            // Récupérer l'usager par son ID
            $usager = Usager::findOrFail($usagerData['id']);
            // Mettre à jour le rôle
            $usager->role = $usagerData['role'];
            // Sauvegarder les changements
            Log::debug('Message de débogage');
            $usager->save();
        }
    
        // Retourner une réponse JSON de succès
        return response()->json(['success' => true]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
