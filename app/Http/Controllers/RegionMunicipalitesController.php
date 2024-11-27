<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Municipalites; 
class RegionMunicipalitesController extends Controller
{
    public function getMunicipalitesParRegion(Request $request)
{
    if (auth()->check() || session()->has('licences')){
    $region = $request->query('region'); 

    if ($region) {
        
        $municipalites = Municipalites::where('regionAdministrative', $region)
            ->orderBy('nom')
            ->distinct()
            ->get(['nom', 'regionAdministrative']);
    } else {
        
        $municipalites = Municipalites::orderBy('nom')
            ->distinct()
            ->get(['nom', 'regionAdministrative']);
    }

    return response()->json($municipalites);
    }
    return redirect()->back();
}
public function getRegionByMunicipalite(Request $request)
{
    if (auth()->check() || session()->has('licences')){
    $municipalite = $request->query('municipalite'); 
    $region = Municipalites::where('nom', $municipalite)->first(['regionAdministrative']);

    return response()->json($region);
    }
    return redirect()->back();
}


}
