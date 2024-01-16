<?php

use App\Http\Controllers\Api\v1\Transaction\MainController;
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
    Route::post('/transactions', [MainController::class, 'store']);
    Route::get('/transactions', [MainController::class, 'index']);
    Route::get('/transactions/analysis', [MainController::class, 'analyze']);
    Route::get('/transactions/{transactionID}', [MainController::class, 'show']);
    Route::patch('/transactions/{transactionID}', [MainController::class, 'update']);
    Route::delete('/transactions/{transactionID}', [MainController::class, 'destroy']);
});
