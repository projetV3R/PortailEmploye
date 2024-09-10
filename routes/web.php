<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsagerController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.admin');
});

