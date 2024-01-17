<?php


use App\Http\Controllers\Api\v1\Goal\MainController;
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
    Route::post('/goals', [MainController::class, 'store']);
    Route::get('/goals', [MainController::class, 'index']);
    Route::get('/goals/{goalID}', [MainController::class, 'show']);
    Route::patch('/goals/{goalID}', [MainController::class, 'update']);
    Route::delete('/goals/{goalID}', [MainController::class, 'destroy']);
});
