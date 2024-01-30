<?php

use App\Http\Controllers\Api\v1\Category\MainController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::post('/categories', [MainController::class, 'store']);
    Route::get('/categories', [MainController::class, 'index']);
    Route::get('/categories/{categoryID}', [MainController::class, 'show']);
    Route::patch('/categories/{categoryID}', [MainController::class, 'update']);
    Route::delete('/categories/{categoryID}', [MainController::class, 'destroy']);
});
