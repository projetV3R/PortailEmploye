<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsagersController;
use Illuminate\Support\Facades\Log;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.admin');
});

// FORMULAIRE CONNEXION
Route::get('/login',
[UsagersController::class, 'index'])->name('showLoginForm');

// ACTION CONNEXION
Route::post('/login',
[UsagersController::class, 'login'])->name('login');

 // ACTION DECONNEXION
 Route::post('/logout',
 [UsagersController::class, 'logout'])->name('logout')->middleware('auth');


// PAGE USAGER DETAIL
Route::get('/usagers/{usager}', 
[UsagersController::class, 'show'])->name('usager.show')->middleware('auth');

Route::get('/usagers', 
[UsagersController::class, 'usagerindex'])->name('usagerindex')->middleware('auth');

Route::get('/creation/usagers',
[UsagersController::class, 'create'])->name('usagers.create')->middleware('auth');

Route::post('/creation/usagers',
[UsagersController::class, 'store'])->name('usagers.store')->middleware('auth');

  // FORMULAIRE MODIFICATION USAGER
Route::get('/usagers/{usager}/modifier/',
[UsagersController::class, 'edit'])->name('usagers.edit')->middleware('auth');
 
Route::patch('/usagers/{usager}/modifier',
[UsagersController::class, 'update'])->name('usagers.update')->middleware('auth');
 
Route::delete('/usagers/{usager}/supprimer', 
[UsagersController::class, 'destroy'])->name('usagers.destroy')->middleware('auth');

//Route::get('/usager/index', [UsagersController::class, 'index'])->name('usagerindex');
