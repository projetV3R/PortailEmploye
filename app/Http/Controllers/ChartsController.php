<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChartsController extends Controller
{

    public function lineChart()
    {
      
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
    
      
        $data = DB::table('fiche_fournisseurs')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    
    
        $counts = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $count = $data->firstWhere('date', $date->toDateString())->count ?? 0;
            $counts[] = $count;
        }

        return response()->json([
            'data' => $counts
        ]);
    }
    


    public function pieChart()
    {
        $data = DB::table('sous_categorie_licence')
        ->join('licences', 'sous_categorie_licence.licence_id', '=', 'licences.id')
        ->join('fiche_fournisseurs', 'licences.fiche_fournisseur_id', '=', 'fiche_fournisseurs.id')
        ->join('sous_categories', 'sous_categorie_licence.sous_categorie_id', '=', 'sous_categories.id')
        ->select('sous_categories.code_sous_categorie as sous_categorie', DB::raw('COUNT(fiche_fournisseurs.id) as fournisseur_count'))
        ->groupBy('sous_categories.code_sous_categorie')
        ->orderByDesc('fournisseur_count')
        ->limit(5)
        ->get();

        return response()->json($data);
    }

    public function getTopCitiesByRegion(Request $request)
{
    $regionValue = $request->input('region_value');

 
    if (!$regionValue || $regionValue === '') {
        $data = DB::table('coordonnees')
            ->select('ville', DB::raw('COUNT(fiche_fournisseur_id) as fournisseur_count'))
            ->where('province', 'Québec') 
            ->groupBy('ville')
            ->orderByDesc('fournisseur_count')
            ->limit(10)
            ->get();

        return response()->json($data);
    }

 
    $data = DB::table('coordonnees')
        ->select('ville', DB::raw('COUNT(fiche_fournisseur_id) as fournisseur_count'))
        ->where('region_administrative', $regionValue)
        ->where('province', 'Québec') 
        ->groupBy('ville')
        ->orderByDesc('fournisseur_count')
        ->limit(10)
        ->get();

    return response()->json($data);
}


}
