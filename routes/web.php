<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsagerController;
use App\Http\Controllers\ParametresSystemeController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', 
[UsagerController::class, 'index'])->name('admin.admin')->middleware('auth');

Route::post('/usagers/update', 
[UsagerController::class, 'update'])->name('usagers.update');

Route::delete('/admin/usager/{id}', 
[UsagerController::class, 'destroy']);

Route::post('/usagers', [UsagerController::class, 'create'])->middleware('auth');

// FORMULAIRE CONNEXION

Route::get('/loginForm', function () {
    return view('Auth.login');
});
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


    
    //STORE PARAMETRE SYSTEME  TODO RAJOUTER CHECK ROLE ADMIN
Route::post('/parametres/store', [ParametresSystemeController::class, 'store']);

//AFFICHER PARAMETRE LISTE  TODO RAJOUTER CHECK ROLE ADMIN
 Route::get('/parametres/', [ParametresSystemeController::class, 'index']);

    //!!! ROUTE DE REDIRECTION ERREUR 404 TOUJOURS A LA FIN DU FICHIER DE ROUTE NE JAMAIS AVOIR DE ROUTE APRES !!!!
 Route::fallback(function () {
        return response()->view('redirection.404', [], 404);});
