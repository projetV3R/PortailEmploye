<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsagerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', 
[UsagerController::class, 'index'])->name('admin.admin');

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
    return view('redirection');});
    