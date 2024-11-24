<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FicheFournisseur;
use App\Models\ParametreSysteme;
use App\Models\Coordonnee;
use App\Models\ProduitsServices;
use App\Models\SousCategories;
use App\Models\SousCategorieLicence;
use App\Models\Licence;
use App\Models\Municipalites;
        class FiltreController extends Controller
    {

     public function getVillesByRegions(Request $request)
    {
    $regions = $request->input('regions', []);
    $produits = $request->input('produits', []);
    $query = Coordonnee::query();


    $query->whereHas('ficheFournisseur', function ($q) {
        $q->where('etat', '!=', 'désactivé');
    });

 
    if (!empty($regions)) {
        $query->whereIn('region_administrative', $regions);
    }
    

    $villes = $query->distinct()->pluck('ville');

    return response()->json(['villesDisponibles' => $villes]);
}


    public function getProduitsByFilters(Request $request)
{
    $regions = $request->input('regions', []);
    $villes = $request->input('villes', []);
    $categorie = $request->input('categorie', ''); 
    $page = $request->input('page', 1);
    $perPage = $request->input('perPage', 100);

    $query = ProduitsServices::select('produits_services.id', 'produits_services.code_categorie', 'produits_services.description')
        ->distinct()
        ->join('produit_service_fiche_fournisseur', 'produits_services.id', '=', 'produit_service_fiche_fournisseur.produit_service_id')
        ->join('fiche_fournisseurs', 'produit_service_fiche_fournisseur.fiche_fournisseur_id', '=', 'fiche_fournisseurs.id')
        ->join('coordonnees', 'fiche_fournisseurs.id', '=', 'coordonnees.fiche_fournisseur_id')
        ->where('fiche_fournisseurs.etat', '!=', 'désactivé')
        ->when(!empty($regions), function ($q) use ($regions) {
            $q->whereIn('coordonnees.region_administrative', $regions);
        })
        ->when(!empty($villes), function ($q) use ($villes) {
            $q->whereIn('coordonnees.ville', $villes);
        })
        ->when(!empty($categorie), function ($q) use ($categorie) {
            $q->where('produits_services.code_categorie', $categorie);
        });


    $categories = ProduitsServices::distinct()->pluck('code_categorie');

 
    $produitsPagines = $query->paginate($perPage, ['*'], 'page', $page);

    return response()->json([
        'produitsDisponibles' => $produitsPagines->items(), 
        'current_page' => $produitsPagines->currentPage(),
        'last_page' => $produitsPagines->lastPage(),
        'per_page' => $produitsPagines->perPage(),
        'total' => $produitsPagines->total(),
    ]);
}


public function getCategoriesProduits(Request $request)
{
    $regions = $request->input('regions', []);
    $villes = $request->input('villes', []);

    $query = ProduitsServices::query();

    if (!empty($regions)) {
        $query->whereHas('fichesFournisseurs.coordonnees', function ($q) use ($regions) {
            $q->whereIn('region_administrative', $regions);
        });
    }

    if (!empty($villes)) {
        $query->whereHas('fichesFournisseurs.coordonnees', function ($q) use ($villes) {
            $q->whereIn('ville', $villes);
        });
    }


    $categories = $query->distinct()->pluck('code_categorie');

    return response()->json(['categories' => $categories]);
}


}
