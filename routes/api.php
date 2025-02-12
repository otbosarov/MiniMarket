<?php

use App\Http\Api\CurrencyApi;
use App\Http\Api\ExcelUploadApi;
use App\Http\Api\InvoiceApi;
use App\Http\Api\UserApi;
use App\Http\Api\WarahouseApi;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\InputProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\OutputProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnityController;
use App\Http\Controllers\UploadToExcelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserUploadToExcelController;
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
    UserApi::route();
    CurrencyApi::api();
    WarahouseApi::api();
    ExcelUploadApi::route();
    InvoiceApi::api();
});
