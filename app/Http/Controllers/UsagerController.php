<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Usager;
use App\Http\Requests\UsagerRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UsagerController extends Controller
{
    
    public function index(Request $request)
    {
            $usagers = Usager::paginate(10); 
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
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:usagers,email',
            'password' => 'required|string|min:6',
            'nom' => 'required|string|max:191',
            'prenom' => 'required|string|max:191',
            'role' => 'required|in:admin,responsable,commis',
        ], [
            'email.required' => 'Le champ email est obligatoire.',
            'email.email' => 'Informations invalides.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le champ mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'nom.required' => 'Le champ nom est obligatoire.',
            'prenom.required' => 'Le champ prénom est obligatoire.',
            'role.required' => 'Le champ rôle est obligatoire.',
        ]);
        
        try {
            $usager = new Usager();
            $usager->email = $request->email;
            $usager->password = Hash::make($request->password);
            $usager->nom = $request->nom;
            $usager->prenom = $request->prenom;
            $usager->role = $request->role;
            $usager->save();
    
            return response()->json(['message' => 'Utilisateur créé avec succès.'], 201);
        } catch (\Exception $e) {
            if ($e->getCode() === '23000') {
                return response()->json(['errors' => ['email' => ['Cet email est déjà utilisé.']]], 422);
            }
            elseif($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            return response()->json(['errors' => ['message' => 'Une erreur s\'est produite.']], 500);
        }
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
        $usagersData = $request->input('usagers');
    
        foreach ($usagersData as $usagerData) {
            $request->validate([
                'usagers.*.role' => 'required|in:admin,responsable,commis',
            ]);
    
            $usager = Usager::findOrFail($usagerData['id']);
            $usager->role = $usagerData['role'];
            $usager->save();
        }      
        
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $usager = Usager::findOrFail($id);
    $usager->delete();
}

}
