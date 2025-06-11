<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;

// Only define GET routes for login/register here, not in both files
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

Route::get('/', function () {
    return view('welcome');
});

// Legacy dashboard route - redirect to appropriate page based on role
Route::get('/dashboard', function () {
    if (Auth::check()) {
        $user = \App\Models\User::with('role')->find(Auth::id());

        $roleName = $user->role->name;

        switch ($roleName) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'owner':
                return redirect('/owner/dashboard');
            case 'renter':
            default:
                return redirect('/vehicles');
        }
    }
    return redirect('/login');
})->middleware(['auth'])->name('dashboard');

Route::get('/owner/dashboard', function () {
    return view('owner.dashboard');
})->middleware(['auth', 'verified'])->name('owner.dashboard');

// Admin routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/rental-requests', [App\Http\Controllers\AdminController::class, 'rentalRequests'])->name('rental-requests');
    Route::patch('/rental-requests/{booking}/approve', [App\Http\Controllers\AdminController::class, 'approveRental'])->name('approve-rental');
    Route::patch('/rental-requests/{booking}/reject', [App\Http\Controllers\AdminController::class, 'rejectRental'])->name('reject-rental');
    Route::get('/car-management', [App\Http\Controllers\AdminController::class, 'carManagement'])->name('car-management');
    Route::patch('/vehicles/{vehicle}/approve', [App\Http\Controllers\AdminController::class, 'approveVehicle'])->name('approve-vehicle');
    Route::patch('/vehicles/{vehicle}/suspend', [App\Http\Controllers\AdminController::class, 'suspendVehicle'])->name('suspend-vehicle');
    Route::get('/user-management', [App\Http\Controllers\AdminController::class, 'userManagement'])->name('user-management');
    Route::get('/financial-analytics', [App\Http\Controllers\AdminController::class, 'financialAnalytics'])->name('financial-analytics');
    Route::get('/system-activity', [App\Http\Controllers\AdminController::class, 'systemActivity'])->name('system-activity');
});

// Email verification route
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Register routes for Google OAuth login and callback
Route::get('/auth/redirect/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/callback/google', [GoogleController::class, 'handleGoogleCallback']);

// Vehicle routes for renters
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Booking routes for renters
    Route::get('/vehicles/{vehicle}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/vehicles/{vehicle}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Owner routes
    Route::prefix('owner')->name('owner.')->group(function () {
        // Vehicle management
        Route::get('/vehicles', [VehicleController::class, 'ownerIndex'])->name('vehicles.index');
        Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
        Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
        Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
        Route::patch('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
        Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

        // Booking management
        Route::get('/bookings', [BookingController::class, 'ownerIndex'])->name('bookings.index');
        Route::patch('/bookings/{booking}/accept', [BookingController::class, 'accept'])->name('bookings.accept');
        Route::patch('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
        Route::patch('/bookings/{booking}/complete', [BookingController::class, 'complete'])->name('bookings.complete');
    });
});

require __DIR__.'/auth.php';
