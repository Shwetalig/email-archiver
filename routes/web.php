<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/google/login', [GoogleController::class, 'login']);
Route::get('/google/callback', [GoogleController::class, 'callback']);
