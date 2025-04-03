<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\MedicineSearchController;
use App\Http\Controllers\Patient\ReservationController;
use App\Http\Controllers\Patient\ProfileController;
use App\Http\Controllers\Patient\AuthController;

/*
|--------------------------------------------------------------------------
| Patient Routes
|--------------------------------------------------------------------------
|
| Routes spécifiques à l'interface des patients
|
*/

// Home page (no authentication required)
Route::get('/', function () {
    return view('patient.home');
})->name('patient.home');

// Authentication routes
Route::prefix('patient/auth')->name('patient.auth.')->group(function () {
    // Login routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Register routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Password reset (à implémenter plus tard)
    Route::get('/password/reset', function() {
        return redirect()->route('patient.auth.login')->with('info', 'La fonctionnalité de réinitialisation du mot de passe sera disponible prochainement.');
    })->name('password.request');
    
    // Social authentication routes
    Route::get('/redirect/{provider}', [AuthController::class, 'redirectToProvider'])->name('redirect');
    Route::get('/callback/{provider}', [AuthController::class, 'handleProviderCallback'])->name('callback');
});

// Routes for terms and privacy policy
Route::get('/terms', function () {
    return view('patient.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('patient.privacy');
})->name('privacy');

// Medicine search routes (no authentication required)
Route::get('/patient/search', [MedicineSearchController::class, 'index'])->name('patient.search.index');
Route::post('/patient/search', [MedicineSearchController::class, 'search'])->name('patient.search.results');
Route::get('/patient/pharmacy/{id}', [MedicineSearchController::class, 'pharmacyDetails'])->name('patient.search.pharmacy');

// Routes requiring patient authentication
Route::middleware(['auth', 'patient'])->prefix('patient')->name('patient.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
    
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Reservation routes
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
}); 