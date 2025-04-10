<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MedicineSearchApiController;
use App\Http\Controllers\Api\PrescriptionAnalysisController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Medicines search API route
Route::get('/medicines/search', [MedicineSearchApiController::class, 'search']);

// Prescription analysis API route
Route::post('/prescription/analyze', [PrescriptionAnalysisController::class, 'analyze']);
