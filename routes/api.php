<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PassportController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    ///--- ROUTES OF AUTH ---///
Route::post('login', [PassportController::class, 'login']);
Route::post('register', [PassportController::class, 'register']);
 
Route::middleware('auth:api')->group(function () {
    Route::get('user', [PassportController::class, 'details']);
    
    ///--- ROUTES OF RESOURCES ---///
    Route::get('/reservations', [ReservationController::class, 'getAll']);
    Route::get('/reservations/{id}', [ReservationController::class, 'getById']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);

    ///--- ROUTES OF ASETS ---///
    Route::get('/asets', [AsetController::class, 'getAll']);
    Route::get('/asets/{id}', [AsetController::class, 'getById']);
    Route::post('/asets', [AsetController::class, 'store']);
    Route::put('/asets/{id}', [AsetController::class, 'update']);
    Route::delete('/asets/{id}', [AsetController::class, 'destroy']);
});
