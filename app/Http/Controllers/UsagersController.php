<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Usager;
use App\Http\Requests\UsagerRequest;
use Illuminate\Support\Facades\Hash;

class UsagersController extends Controller
{
    
    public function index()
    {
        $fillable = Usager::all();
        return view('Auth.login', compact('fillable'));        
    }

    public function usagerindex()
    {
        $fillable = Usager::all();
        $usagers = Usager::all();
        return view('Auth.index', compact('usagers','fillable'));
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
            return redirect()->route('usagerindex')->with("message",'Connexion réussi');
        }
        else
            {
                Session::flush();
                return redirect()->route('showLoginForm')->with("message",'Informations invalides');
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
        $roleuser = Usager::orderBy('role')->get();
        return View('Auth.create', compact('roleuser'));    }
    /**
     * Display the specified resource.
     */
    public function show(Usager $usager)
    {
        return View('Auth.show', compact('usager'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usager $usager)
    {
       $roleuser = Usager::orderBy('role')->get();
        return View('Auth.edit', compact('usager', 'roleuser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usager $usager)
    {
        //log::debug('loop update debut');
        try
        {
            $usager->email = $request->email;   
            
            if($request->filled('password_new'))
            {
                if(Hash::check($request->password, $request->password_old))
                {
                    if(!$request->password_new || !$resquest->password_new_confirmation)
                        return redirect()->back()->withErrors(['Mot de passe est requis']);

                    if($request->password_new != $request->password_new_confirmation)
                        return redirect()->back()->withErrors(['Mot de passe doit être le même dans la case de validation']);                  

                    if(Str::length($request->password_new) < 4 || Str::length($request->password_new) > 50)
                        return redirect()->back()->withErrors(['Nouveau mot de passe doit être entre 4 et 50 caractères']);                  
                    $usager->password = Hash::make($request->password_new);
                }
                else
                {
                    return redirect()->back()->withErrors(['Mot de passe incorrect']);
                }
            }
            //log::debug('password');
            $usager->email = $request->email;
            //log::debug('email');
            
            //log::debug($request->role);
            $usager->save();
           // log::debug('END');
            if(Auth::user()->id == $usager->id)
                return redirect()->route('usager.show', [$usager]);
            else
                return redirect()->route('usagerindex')->with('message', "Modification de " . $usager->nom_usager . " réussi!");
        }
        catch(\Throwable $e)
        {
            Log::debug($e);
            if(Auth::user()->id == $usager->id)
                return redirect()->route('usager.show', [$usager])->withErrors(['La modification n\'a pas fonctionné']);
            else
                return redirect()->route('usagerindex')->withErrors(['La modification n\'a pas fonctionné']);
        }
        return redirect()->route('usagerindex');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try
        {
            $usager = Usager::findOrFail($id);
 
            $usager->delete();
            return redirect()->route('usagerindex')->with('message', "Suppression de " . $usager->nom . " réussi!");
        }
        catch(\Throwable $e)
        {
            Log::debug($e);
            return redirect()->route('usagerindex')->withErrors(['la suppression n\'a pas fonctionné']); 
        }
            return redirect()->route('usagerindex');
    }
}
