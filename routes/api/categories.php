<?php

use App\Http\Controllers\Api\v1\Category\MainController;
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
    Route::post('/categories', [MainController::class, 'store']);
    Route::get('/categories', [MainController::class, 'index']);
    Route::get('/categories/{categoryID}', [MainController::class, 'show']);
    Route::patch('/categories/{categoryID}', [MainController::class, 'update']);
    Route::delete('/categories/{categoryID}', [MainController::class, 'destroy']);
});
