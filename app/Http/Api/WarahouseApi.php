<?php

namespace App\Http\Api;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InputProductController;
use App\Http\Controllers\OutputProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnityController;
use Illuminate\Support\Facades\Route;

class WarahouseApi
{
    public static function api()
    {
        Route::resource('category', CategoryController::class);
        Route::put('category_changeActive/{id}', [CategoryController::class, 'changeActive']);

        Route::resource('supplier', SupplierController::class);
        Route::put('supplier_changeActive/{id}', [SupplierController::class, 'changeAtive']);

        Route::resource('product', ProductController::class);
        Route::put('product_changeActive/{id}', [ProductController::class, 'changeActive']);

        Route::resource('unity', UnityController::class);

        Route::resource('inputProduct', InputProductController::class);

        Route::resource('outputProduct', OutputProductController::class);

        Route::get('productDetail', [ProductDetailController::class, 'index']);
        Route::put('productDetail_update/{id}', [ProductDetailController::class, 'update']);
    }
}
