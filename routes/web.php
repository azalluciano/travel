<?php

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
//Export Destination routes
Route::get('/export-destinations', [DestinationController::class, 'export'])->name('destinations.export');

// Admin routes (protected by admin middleware)
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin destination management
    Route::get('/destinations', [AdminController::class, 'index'])->name('destinations.index');
    Route::get('/destinations/create', [AdminController::class, 'create'])->name('destinations.create');
    Route::post('/destinations', [AdminController::class, 'store'])->name('destinations.store');
    Route::get('/destinations/{destination}/edit', [AdminController::class, 'edit'])->name('destinations.edit');
    Route::put('/destinations/{destination}', [AdminController::class, 'update'])->name('destinations.update');
    Route::delete('/destinations/{destination}', [AdminController::class, 'destroy'])->name('destinations.destroy');
});