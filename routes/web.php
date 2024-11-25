<?php

use App\Http\Controllers\FicheFournisseurController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsagerController;
use App\Http\Controllers\ParametresSystemeController;
use App\Http\Controllers\ModelesController;
use App\Http\Controllers\FiltreController;
 
 
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



Route::get('/listeFournisseur', [FicheFournisseurController::class, 'index'])->name('fiches.index');

//Route::get('/profil', [FicheFournisseurController::class, 'profil'])->name('profil');

Route::get('/profil/{id}', [FicheFournisseurController::class, 'profil'])->name('profil');

Route::post('/update-selection', [FicheFournisseurController::class, 'updateSelection'])->name('update.selection');


Route::get('/get-villes', [FiltreController::class, 'getVillesByRegions'])->name('get.villes');
Route::get('/get-produits', [FiltreController::class, 'getProduitsByFilters'])->name('get.produits');
Route::get('/get-sous-categories-licences', [FiltreController::class, 'getSousCategoriesLicencesByFilters'])->name('get.sousCategoriesLicences');
Route::get('/categories-produits', [FiltreController::class, 'getCategoriesProduits'])->name('get.categories');
Route::get('/licence/filtre', [FiltreController::class, 'getSousCategoriesFilter'])->name('get.sousCategoriesFilter');
//!!! ROUTE DE REDIRECTION ERREUR 404 TOUJOURS A LA FIN DU FICHIER DE ROUTE NE JAMAIS AVOIR DE ROUTE APRES !!!!
Route::fallback(function () {
    return response()->view('redirection.404', [], 404);
});
