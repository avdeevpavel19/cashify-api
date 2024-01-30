<?php

use App\Http\Controllers\Api\v1\FinancialReport\MainController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/financial-report', [MainController::class, 'generate']);
});
