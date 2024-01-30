<?php

use App\Http\Controllers\Api\v1\Goal\MainController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::post('/goals', [MainController::class, 'store']);
    Route::get('/goals', [MainController::class, 'index']);
    Route::get('/goals/{goalID}', [MainController::class, 'show']);
    Route::patch('/goals/{goalID}', [MainController::class, 'update']);
    Route::delete('/goals/{goalID}', [MainController::class, 'destroy']);
});
