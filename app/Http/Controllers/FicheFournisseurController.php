<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FicheFournisseur;
use App\Models\ParametreSysteme;
use App\Models\Coordonnee;
use App\Models\Municipalites;
use Illuminate\Http\Request;
     class FicheFournisseurController extends Controller
    {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 5);
        $page = $request->input('page', 1);
        $regions = $request->input('regions', []);
        $villes = $request->input('villes', []);
    
        $query = FicheFournisseur::with('coordonnees');
    
       
        if (!empty($regions)) {
            $query->whereHas('coordonnees', function ($q) use ($regions) {
                $q->whereIn('region_administrative', $regions);
            });
        }
    
        if (!empty($villes)) {
            $query->whereHas('coordonnees', function ($q) use ($villes) {
                $q->whereIn('ville', $villes);
            });
        }
        if ($request->has('produits') && !empty($request->produits)) {
            $produits = $request->input('produits');
            $query->whereHas('produitsServices', function($q) use ($produits) {
                $q->whereIn('produits_services.id', $produits);
            });
        }

        if ($request->has('etats') && !empty($request->etats)) {
            $etats = $request->input('etats');
            $query->whereIn('etat', $etats);
        }
       
        $query->where('etat', '!=', 'désactivé');
    
        $fiches = $query->paginate($perPage, ['*'], 'page', $page);
    
        if ($request->ajax()) {
            return response()->json($fiches);
        }
    
        $selectedCompanies = session('selectedCompanies', []);
        return view('Fournisseur.liste_fournisseur', compact('fiches', 'selectedCompanies'));
    }
    


     public function profil($id)
    {
        $fournisseur = FicheFournisseur::find($id);
        $licence = $fournisseur->licence()->with('sousCategories.categorie')->first();
        $maxFileSize = ParametreSysteme::where('cle', 'taille_fichier')->value('valeur_numerique');

        return view('Fournisseur/profil_fournisseur', compact('maxFileSize', 'fournisseur', 'licence'));
    }

    public function updateSelection(Request $request)
    {
        $selectedCompanies = $request->input('selectedCompanies', []);
        session(['selectedCompanies' => $selectedCompanies]);

        return response()->json(['message' => 'Sélection mise à jour']);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
