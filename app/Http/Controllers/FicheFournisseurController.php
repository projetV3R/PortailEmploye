<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FicheFournisseur;
use App\Models\ParametreSysteme;
use Illuminate\Http\Request;
use App\Notifications\FournisseurApproveNotification;
use App\Notifications\FournisseurRefusNotification;



class FicheFournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 5);
        $fiches = FicheFournisseur::with('coordonnees')->paginate($perPage);
        $selectedCompanies = session('selectedCompanies', []);

        if ($request->ajax()) {
            return response()->json($fiches);
        }

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
    public function reject(Request $request, $id)
    {
        $fournisseur = FicheFournisseur::findOrFail($id);

        // Mise à jour de l'état à "refuser"
        $fournisseur->etat = 'refuser';
        $fournisseur->save();

        // Envoi d'une notification de refus
        $reason = $request->input('reason', null);
        $includeReason = $request->input('includeReason', false);
        $fournisseur->notify(new FournisseurRefusNotification($fournisseur, $reason, $includeReason));

        return response()->json(['message' => 'Demande refusée avec succès.']);
    }

    public function approve($id)
    {
        $fournisseur = FicheFournisseur::findOrFail($id);

        // Mise à jour de l'état à "accepter"
        $fournisseur->etat = 'accepter';
        $fournisseur->save();

        // Envoi d'une notification d'approbation
        $fournisseur->notify(new FournisseurApproveNotification($fournisseur));

        return response()->json(['message' => 'Demande approuvée avec succès.']);
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
