<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsetController;
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

Route::get('/asets', [AsetController::class, 'getAll']);
Route::get('/asets/{id}', [AsetController::class, 'getById']);
Route::post('/asets', [AsetController::class, 'store']);
Route::put('/asets/{id}', [AsetController::class, 'update']);
Route::delete('/asets/{id}', [AsetController::class, 'destroy']);