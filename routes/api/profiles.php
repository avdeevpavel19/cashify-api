<?php

use App\Http\Controllers\Api\v1\Profile\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::patch('/profiles', [MainController::class, 'store']);
    Route::post('/profiles/avatar', [MainController::class, 'uploadAvatar']);
    Route::get('/profiles', [MainController::class, 'index']);
    Route::put('/profiles/change-password', [MainController::class, 'changePassword']);
    Route::post('/profiles/currency', [MainController::class, 'changeCurrency']);
});
