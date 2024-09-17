<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsagerController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.admin');
});

// FORMULAIRE CONNEXION
Route::get('/loginForm',
[UsagerController::class, 'index'])->name('showLoginForm');

// ACTION CONNEXION
Route::post('/login',
[UsagerController::class, 'login'])->name('login');

 // ACTION DECONNEXION
 Route::post('/logout',
 [UsagerController::class, 'logout'])->name('logout')->middleware('auth');

//ACCES PAGE DASHBOARD APRES ACTION LOGIN
Route::get('/dashboard', function () {
    return view('Auth.dashboard')->name('coco');
});
 