<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\MedicineSearchController;
use App\Http\Controllers\Patient\ReservationController as PatientReservationController;
use App\Http\Controllers\Pharmacy\DashboardController;
use App\Http\Controllers\Pharmacy\InventoryController;
use App\Http\Controllers\Pharmacy\ReservationController as PharmacyReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Welcome page
Route::get('/', function () {
    return redirect()->route('patient.home');
});

// Authentication routes - redirect to our custom auth routes
Route::get('/login', function() {
    return redirect()->route('patient.auth.login');
})->name('login');

Route::get('/register', function() {
    return redirect()->route('patient.auth.register');
})->name('register');

// Patient routes
Route::prefix('patient')->name('patient.')->group(function () {
    // Medicine search routes (no authentication required)
    Route::get('/search', [MedicineSearchController::class, 'index'])->name('search.index');
    Route::post('/search', [MedicineSearchController::class, 'search'])->name('search.results');
    Route::get('/pharmacies', [MedicineSearchController::class, 'pharmacyList'])->name('search.pharmacy.list');
    Route::get('/pharmacy/{id}', [MedicineSearchController::class, 'pharmacyDetails'])->name('search.pharmacy.details');
    
    // Routes requiring patient authentication
    Route::middleware(['auth', 'patient'])->group(function () {
        // Reservation routes
        Route::get('/reservations', [PatientReservationController::class, 'index'])->name('reservations.index');
        Route::post('/reservations', [PatientReservationController::class, 'store'])->name('reservations.store');
        Route::get('/reservations/{id}', [PatientReservationController::class, 'show'])->name('reservations.show');
        Route::post('/reservations/{id}/cancel', [PatientReservationController::class, 'cancel'])->name('reservations.cancel');
    });
});

// Pharmacy routes (all require pharmacy authentication)
Route::prefix('pharmacy')->name('pharmacy.')->middleware(['auth', 'pharmacy'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/profile/edit', [DashboardController::class, 'editProfile'])->name('dashboard.edit_profile');
    Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('dashboard.update_profile');
    
    // Inventory routes
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    
    // Reservation routes
    Route::get('/reservations', [PharmacyReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{id}', [PharmacyReservationController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{id}/status', [PharmacyReservationController::class, 'updateStatus'])->name('reservations.update_status');
    Route::get('/reservations/export', [PharmacyReservationController::class, 'export'])->name('reservations.export');
});

// Inclure les routes des patients
require __DIR__.'/patient.php';

// Inclure les routes des pharmacies
require __DIR__.'/pharmacy.php';
