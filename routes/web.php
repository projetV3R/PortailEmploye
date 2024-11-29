<?php

use App\Http\Controllers\FicheFournisseurController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsagerController;
use App\Http\Controllers\ParametresSystemeController;
use App\Http\Controllers\ModelesController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\FiltreController;
use App\Http\Controllers\RegionMunicipalitesController;
 
 
// FORMULAIRE CONNEXION
Route::get('/', function () {
    return view('Auth.login');})->name('login');
 
// ACTION CONNEXION
Route::post('/login', 
[UsagerController::class, 'login'])->name('connexion');
 
// ACTION DECONNEXION
Route::post('/logout', 
[UsagerController::class, 'logout'])->name('logout')->middleware('auth');
 
Route::get('/dashboard',
[UsagerController::class, 'dashboard'])->name('dashboard')->middleware('auth');
 
Route::get('/redirection', function () {
    return view('redirection.403');});
 
Route::get('/usagers', [UsagerController::class, 'index']);

 
Route::get('/admin', function () {
    return view('admin.admin');});
 
Route::post('/usagers/update',
[UsagerController::class, 'update'])->name('usagers.update');
 
Route::delete('/admin/usager/{id}',
[UsagerController::class, 'destroy']);
 
Route::post('/storeusager', 
[UsagerController::class, 'store'])->middleware('auth');
 
Route::get('/usagers/count-admins', 
[UsagerController::class, 'countAdmins']);

 
    //STORE PARAMETRE SYSTEME  TODO RAJOUTER CHECK ROLE ADMIN
Route::post('/parametres/store', [ParametresSystemeController::class, 'store']);
 
//AFFICHER PARAMETRE LISTE  TODO RAJOUTER CHECK ROLE ADMIN
 Route::get('/parametres/', [ParametresSystemeController::class, 'index']);
 
 // Route pour récupérer les modèles de mail
Route::get('/modeles', [ModelesController::class, 'index']);
 
Route::get('/modeles/{id}', [ModelesController::class, 'show']);
 
Route::put('/modeles/{id}', [ModelesController::class, 'update']);

// route data line-Chart
Route::get('/line-chart-data', [ChartsController::class, 'lineChart']);

// route data pie-Chart
Route::get('/chart/pie', [ChartsController::class, 'pieChart']);

Route::get('/listeFournisseur', [FicheFournisseurController::class, 'index'])->name('fiches.index');

//Route::get('/profil', [FicheFournisseurController::class, 'profil'])->name('profil');

Route::get('/profil/{id}', [FicheFournisseurController::class, 'profil'])->name('profil');

Route::post('/update-selection', [FicheFournisseurController::class, 'updateSelection'])->name('update.selection');


Route::get('/get-villes', [FiltreController::class, 'getVillesByRegions'])->name('get.villes');
Route::get('/get-produits', [FiltreController::class, 'getProduitsByFilters'])->name('get.produits');
Route::get('/get-sous-categories-licences', [FiltreController::class, 'getSousCategoriesLicencesByFilters'])->name('get.sousCategoriesLicences');
Route::get('/categories-produits', [FiltreController::class, 'getCategoriesProduits'])->name('get.categories');
Route::get('/licence/filtre', [FiltreController::class, 'getSousCategoriesFilter'])->name('get.sousCategoriesFilter');

//Route pour MODIFICATION 
Route::get('/Identification/{fournisseurId}/modif', [FicheFournisseurController::class, "editIdentif"])->name("EditIdentification")->middleware('auth');
Route::post('/Identification/{id}/update', [FicheFournisseurController::class, "updateProfile"])->name("UpdateIdentification")->middleware('auth');

Route::get('/produits-services/multiple/{id}', [FicheFournisseurController::class, 'getMultiple'])->name('produits-services.getMultiple');
Route::get('/categories', [FicheFournisseurController::class, 'getCategories']);
Route::get('/produits-services/{fournisseurId}/modif/', [FicheFournisseurController::class, "editProduit"])->name("EditProduit")->middleware('auth');
Route::post('/produits-services/update/{id}', [FicheFournisseurController::class, "updateProduit"])->name("UpdateProduit")->middleware('auth');
Route::get('/search', [FicheFournisseurController::class, 'search']);

Route::get('/municipalites-par-region', [RegionMunicipalitesController::class, 'getMunicipalitesParRegion']);
Route::get('/region-par-municipalite', [RegionMunicipalitesController::class, 'getRegionByMunicipalite']);
Route::get('/Coordonnees/{fournisseurId}/modif', [FicheFournisseurController::class, "editCord"])->name("EditCoordonnee")->middleware('auth');
Route::post('/Coordonnees/update/{id}', [FicheFournisseurController::class, "updateCoordonnee"])->name("UpdateCoordonnee")->middleware('auth');
Route::get('/fournisseur/coordonnees/data/{id}', [FicheFournisseurController::class, 'getCoordonneeData'])->name('CoordonneesData');


Route::get('/sous-categories/{type}', [FicheFournisseurController::class, 'getSousCategories']);
Route::get('/sous-categories/affichage/multiple/{id}', [FicheFournisseurController::class, 'getSousCategoriesMultiple']);
Route::get('/Licences/{fournisseurId}/modif', [FicheFournisseurController::class, "editLicence"])->name("EditLicence")->middleware('auth');
Route::post('/Licences/{id}/update', [FicheFournisseurController::class, "updateLicence"])->name("UpdateLicence")->middleware('auth');
Route::get('/Licence/get-licence-data/{id}', [FicheFournisseurController::class, 'getLicenceData'])->name('getLicenceData');

Route::get('/Contacts/{fournisseurId}/modif', [FicheFournisseurController::class, "editContact"])->name("EditContact")->middleware('auth');
Route::post('/Contacts/update/{id}', [FicheFournisseurController::class, "updateContact"])->name("UpdateContact")->middleware('auth');
Route::get('/Contacts/getData/{id}', [FicheFournisseurController::class, "getContacts"])->name("getContacts")->middleware('auth');


Route::get('/fournisseur/{fournisseurId}/edit-doc', [FicheFournisseurController::class, "editDoc"])->name("EditDoc")->middleware('auth');
Route::post('/fournisseur/{id}/update-doc', [FicheFournisseurController::class, "updateDoc"])->name("UpdateDoc")->middleware('auth');
Route::get('/fournisseur/{id}/get-documents', [FicheFournisseurController::class, 'getDocuments']);

Route::get('/Finances/{fournisseurId}/modif', [FicheFournisseurController::class, "editFinance"])->name("EditFinance")->middleware('auth');
Route::post('/Finances/update/{id}', [FicheFournisseurController::class, "updateFinance"])->name("UpdateFinance")->middleware('auth');

Route::post('/Activation', [FicheFournisseurController::class, "reactivationFiche"])->name("reactivationFiche")->middleware('auth');
Route::post('/Desactivation', [FicheFournisseurController::class, 'desactivationFiche'])->name('desactivationFiche')->middleware('auth');
Route::delete('/licence/delete/{id}', [FicheFournisseurController::class, 'deleteLicence'])->name('deleteLicence')->middleware('auth');


//!!! ROUTE DE REDIRECTION ERREUR 404 TOUJOURS A LA FIN DU FICHIER DE ROUTE NE JAMAIS AVOIR DE ROUTE APRES !!!!
Route::fallback(function () {
    return response()->view('redirection.404', [], 404);
});