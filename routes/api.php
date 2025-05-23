<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmailController;
use App\Http\Controllers\Api\BidController;
use App\Http\Controllers\Api\ReportsController;
use App\Http\Controllers\Api\ReportController;

Route::get('/emails', [EmailController::class, 'index']);
Route::apiResource('bids', BidController::class);
Route::get('/reports/status', [ReportsController::class, 'bidsByStatus']);
Route::get('/reports/timeline', [ReportsController::class, 'bidsTimeline']);
Route::get('/reports/bid-types', [ReportController::class, 'bidTypes']);
Route::get('/reports/classifications', [ReportController::class, 'classifications']);
