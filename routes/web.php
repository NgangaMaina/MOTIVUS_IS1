<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\GoogleController;

// Only define GET routes for login/register here, not in both files
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

Route::get('/', function () {
    return view('welcome');
});

// Register routes for Google OAuth login and callback
Route::get('/auth/redirect/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/callback/google', [GoogleController::class, 'handleGoogleCallback']);

require __DIR__.'/auth.php';
