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
            return view('admin.admin', compact('usagers'));
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
                'password' => Hash::make($validatedData['password']),
                'nom' => $validatedData['nom'],
                'prenom' => $validatedData['prenom'],
                'role' => $validatedData['role'],
            ]);
    
            return response()->json(['success' => 'Utilisateur ajouté avec succès!'], 201);
        } catch (\Exception $e) {
    
            if ($e instanceof \Illuminate\Database\QueryException && $e->errorInfo[1] == 1062) {
                return response()->json(['errors' => ['email' => ['L\'email est déjà utilisé.']]], 422);
            }
    
            return response()->json(['errors' => ['email' => ['Une erreur est survenue lors de l\'ajout de l\'utilisateur.']]], 500);
        }
    }
    
        public function countAdmins()
    {
        $count = Usager::where('role', 'admin')->count();
        return response()->json($count);
    }


 /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
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
    $currentUserId = Auth::id();

    if ($id == $currentUserId) {
        return response()->json(['message' => 'Vous ne pouvez pas supprimer votre propre compte.'], 403);
    }

    $usager = Usager::findOrFail($id);
    $usager->delete();

    return response()->json(['message' => 'Utilisateur supprimé avec succès.'], 200);
}


}
