<?php

namespace App\Http\Api;

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceProductsController;
use Illuminate\Support\Facades\Route;

class InvoiceApi
{
    public static function api()
    {
        Route::get('invoice_show', [InvoiceController::class, 'index']);
        Route::post('invoice_create', [InvoiceController::class, 'store']);

        Route::get('invoice_products_show', [InvoiceProductsController::class, 'index']);
        Route::post('invoice_products_create', [InvoiceProductsController::class, 'store']);
    }
}
