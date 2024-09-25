<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsagerController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', 
[UsagerController::class, 'index'])->name('admin.admin');

Route::get('/redirection', function () {
    return view('redirection');
});