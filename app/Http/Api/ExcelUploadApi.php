<?php

namespace App\Http\Api;

use App\Http\Controllers\BenefitController;
use App\Http\Controllers\UploadToExcelController;
use App\Http\Controllers\UserUploadToExcelController;
use Illuminate\Support\Facades\Route;

class ExcelUploadApi
{
    public static function route()
    {
        Route::get('miniMarketBenifit', [BenefitController::class, 'index']);

        Route::controller(UploadToExcelController::class)->group(function () {
            Route::get('input_products_to_excel', 'InputProductsExcel');
            Route::get('output_products_to_excel', 'OutputProductsExcel');
            Route::get('product_details_to_excel', 'ProductDetailsExcel');
            Route::get('benefits_to_excel', 'BenefitsExcel');
        });

        Route::get('UserUploadToExcel', [UserUploadToExcelController::class, 'index']);
    }
}
