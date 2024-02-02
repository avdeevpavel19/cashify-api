<?php

use App\Http\Controllers\Api\v1\ExchangeRates\MainController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/currencies/get-exchange-rates', [MainController::class, 'get']);
});
