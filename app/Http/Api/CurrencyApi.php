<?php

namespace App\Http\Api;

use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;

class CurrencyApi
{
    public static function api()
    {
        Route::controller(CurrencyController::class)->group(function () {
            Route::get('todayExchangeRateShow', 'todayExchangeRate');
            Route::post('exchangeRateCreate', 'exchangeRateStore');
            Route::put('exchangeRateUpdate/{id}', 'exchangeRateUpdate');
            Route::get('CurrencyShow', 'index');
        });
    }
}
