<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// M-PESA callback route
Route::post('/mpesa/callback', [PaymentController::class, 'mpesaCallback']);


