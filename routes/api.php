<?php

use App\Http\Controllers\BenefitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\InputProductController;
use App\Http\Controllers\OutputProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnityController;
use App\Http\Controllers\UploadToExcelController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user_register', [UserController::class, 'register']);
Route::post('user_login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::controller(UserController::class)->group(function () {
        Route::put('user_update/{id}', 'update');
        Route::delete('user_delete/{id}', 'destroy');
        Route::put('user_changeActive/{id}', 'changeActive');
        Route::get('users_show', 'index');
        Route::get('get_profil', 'userInfo');
    });
    Route::controller(CurrencyController::class)->group(function () {
        Route::get('todayExchangeRateShow', 'todayExchangeRate');
        Route::post('exchangeRateCreate', 'exchangeRateStore');
        Route::put('exchangeRateUpdate/{id}', 'exchangeRateUpdate');
        Route::get('CurrencyShow', 'index');
    });

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

    Route::get('miniMarketBenifit', [BenefitController::class, 'index']);

    Route::controller(UploadToExcelController::class)->group(function () {
        Route::get('input_products_to_excel', 'InputProductsExcel');
        Route::get('output_products_to_excel', 'OutputProductsExcel');
        Route::get('product_details_to_excel', 'ProductDetailsExcel');
        Route::get('benefits_to_excel', 'BenefitsExcel');
    });
});
