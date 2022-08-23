<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VesselsController;
use App\Http\Controllers\VoyagesController;
use App\Http\Controllers\TrackingsController;
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

Route::post('create-vessel', [VesselsController::class, 'createVessel']);
Route::post('update-vessel', [VesselsController::class, 'updateVessel']);
Route::get('get-vessel-list', [VesselsController::class, 'getVesselList']);

Route::post('create-voyage', [VoyagesController::class, 'createVoyage']);
Route::post('update-voyage', [VoyagesController::class, 'updateVoyage']);
Route::get('get-voyage-list', [VoyagesController::class, 'getVoyageList']);

Route::post('add-tracking', [TrackingsController::class, 'addTracking']);
Route::post('update-tracking', [TrackingsController::class, 'updateTracking']);
Route::get('get-tracking-list', [TrackingsController::class, 'getTrackingList']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
