<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChartsController extends Controller
{
    /**
     * Retourne les données pour le graphique des inscriptions mensuelles.
     */
    public function lineChart()
    {
        $currentYear = Carbon::now()->year;

        $data = DB::table('fiche_fournisseurs')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Remplir les mois manquants avec 0
        $formattedData = array_fill(1, 12, 0);
        foreach ($data as $item) {
            $formattedData[$item->month] = $item->count;
        }

        // Retourner les données formatées en JSON
        return response()->json(array_values($formattedData));
    }
}
