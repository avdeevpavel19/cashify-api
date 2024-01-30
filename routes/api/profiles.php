<?php

use App\Http\Controllers\Api\v1\Profile\MainController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::patch('/profiles', [MainController::class, 'store']);
    Route::post('/profiles/avatar', [MainController::class, 'uploadAvatar']);
    Route::get('/profiles', [MainController::class, 'index']);
    Route::put('/profiles/change-password', [MainController::class, 'changePassword']);
    Route::post('/profiles/currency', [MainController::class, 'changeCurrency']);
});
