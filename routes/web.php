<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsagerController;
use Illuminate\Support\Facades\Log;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.admin');
});
/*Route::get('/connexionEmployer', function () {
    return view('Auth.connexion');
});*/

// FORMULAIRE CONNEXION
Route::get('/login',
[UsagerController::class, 'index'])->name('showLoginForm');

// ACTION CONNEXION
Route::post('/login',
[UsagerController::class, 'login'])->name('login');

 // ACTION DECONNEXION
 Route::post('/logout',
 [UsagerController::class, 'logout'])->name('logout')->middleware('auth');


 Route::get('/connexion',
 [UsagerController::class, 'usagerindex'])->name('usagerindex');
 