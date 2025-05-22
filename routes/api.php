<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmailController;

Route::get('/emails', [EmailController::class, 'index']);

