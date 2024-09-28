<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsagerController;

Route::get('/', function () {
    return view('welcome');
});


// FORMULAIRE CONNEXION
Route::get('/loginForm',
[UsagerController::class, 'index'])->name('login');

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
    

    
Route::get('/admin', function () {
    return view('admin.admin');});
    


    //!!! ROUTE DE REDIRECTION ERREUR 404 TOUJOURS A LA FIN DU FICHIER DE ROUTE NE JAMAIS AVOIR DE ROUTE APRES !!!!
 Route::fallback(function () {
        return response()->view('redirection.404', [], 404);});