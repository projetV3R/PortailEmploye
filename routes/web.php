<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsagerController;
use App\Http\Controllers\ParametresSystemeController;
use App\Http\Controllers\ModelesController;
 
 
 
// FORMULAIRE CONNEXION
Route::get('/', function () {
    return view('Auth.login');})->name('login');
 
// ACTION CONNEXION
Route::post('/login', [UsagerController::class, 'login'])->name('connexion');
 
// ACTION DECONNEXION
Route::post('/logout', [UsagerController::class, 'logout'])->name('logout')->middleware('auth');
 
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
 
Route::post('/storeusager', [UsagerController::class, 'store'])->middleware('auth');
 
Route::get('/usagers/count-admins', [UsagerController::class, 'countAdmins']);
 
    //STORE PARAMETRE SYSTEME  TODO RAJOUTER CHECK ROLE ADMIN
Route::post('/parametres/store', [ParametresSystemeController::class, 'store']);
 
//AFFICHER PARAMETRE LISTE  TODO RAJOUTER CHECK ROLE ADMIN
 Route::get('/parametres/', [ParametresSystemeController::class, 'index']);
 
 // Route pour récupérer les modèles de mail
Route::get('/modeles', [ModelesController::class, 'index']);
 
Route::get('/modeles/{id}', [ModelesController::class, 'show']);
 
Route::put('/modeles/{id}', [ModelesController::class, 'update']);
 
    //!!! ROUTE DE REDIRECTION ERREUR 404 TOUJOURS A LA FIN DU FICHIER DE ROUTE NE JAMAIS AVOIR DE ROUTE APRES !!!!
 Route::fallback(function () {
        return response()->view('redirection.404', [], 404);});