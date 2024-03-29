<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Auth\RegisterController;
use App\Http\Controllers\Api\v1\Auth\LoginController;
use App\Http\Controllers\Api\v1\Auth\VerificationController;
use App\Http\Controllers\Api\v1\Auth\ResetPasswordController;

Route::post('/users', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/email/resend', [VerificationController::class, 'resend']);
    Route::post('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
});

Route::post('/password/link', [ResetPasswordController::class, 'sendLinkToEmail']);
Route::put('/password/{token}', [ResetPasswordController::class, 'reset']);

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::post('/logout', [LoginController::class, 'logout']);
});
