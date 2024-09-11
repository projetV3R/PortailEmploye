<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsagerController;
use App\Http\Controllers\UsagersController;
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
[UsagersController::class, 'index'])->name('showLoginForm');

// ACTION CONNEXION
Route::post('/login',
[UsagersController::class, 'login'])->name('login');

 // ACTION DECONNEXION
 Route::post('/logout',
 [UsagersController::class, 'logout'])->name('logout')->middleware('auth');


 Route::get('/connexion', function () {
    return view('Auth.dashboard');
});