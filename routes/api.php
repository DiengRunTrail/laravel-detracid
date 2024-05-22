<?php

use App\Http\Controllers\APIUserController;
use App\Http\Controllers\TrackingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// user routes
Route::post('/login', [APIUserController::class, 'login'])->name('api-login');
Route::get('/profile/{id}', [APIUserController::class, 'profile'])->name('api-user-profile');

// user location
Route::get('/locations', [TrackingController::class, 'index'])->name('user-location');
Route::post('/submit', [TrackingController::class, 'submit'])->name('add-user-location');

// checkpoint
Route::get('/checkpoints', [TrackingController::class, 'getCheckpoints'])->name('get-user-checkpoint');
Route::post('/checkpoints', [TrackingController::class, 'submitCheckpoint'])->name('submit-checkpoint');
