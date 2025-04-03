<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pharmacy\DashboardController;
use App\Http\Controllers\Pharmacy\InventoryController;
use App\Http\Controllers\Pharmacy\ReservationController;
use App\Http\Controllers\Pharmacy\ProfileController;

/*
|--------------------------------------------------------------------------
| Pharmacy Routes
|--------------------------------------------------------------------------
|
| Routes spécifiques à l'interface des pharmacies
|
*/

// Pharmacy routes (all require pharmacy authentication)
Route::prefix('pharmacy')->name('pharmacy.')->middleware(['auth', 'pharmacy'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Inventory routes
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    
    // Reservation routes
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{id}/status', [ReservationController::class, 'updateStatus'])->name('reservations.status');
    Route::get('/reservations/export', [ReservationController::class, 'export'])->name('reservations.export');
}); 