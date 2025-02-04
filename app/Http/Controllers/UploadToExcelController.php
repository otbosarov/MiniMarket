<?php

namespace App\Http\Controllers;

use App\Jobs\BenefitExcelUploadJob;
use App\Jobs\InputProductExcelUploadJob;
use App\Jobs\OutputProductExcelUploadJob;
use App\Jobs\ProductDetailExcelUploadJob;

class UploadToExcelController extends Controller
{
    public function InputProductsExcel()
    {
        // if (!($this->check('upload_excel', 'report'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
        $startDate = request('start_date');
        $endDate = request('end_date');

        $now = date("Y_m_d_H_i_s");
        $userId = auth()->id();
        $fileName =  $now . "_" . $userId . "_input_products_excel.xlsx";
        $url = "public/" . $fileName;

       

        dispatch(new InputProductExcelUploadJob($url, $startDate, $endDate));

        return response()->json([
            'message' => "Kirim qilingan mahsulotlar excelga yuklandi",
            'file_url' => "http://192.168.13.161:8002/storage/" . $fileName
        ], 200);
    }
    public function OutputProductsExcel()
    {
        // if (!($this->check('upload_excel', 'report'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
        $startDate = request('start_date');
        $endDate = request('end_date');

        $now = date("Y_m_d_H_i_s");
        $userId = auth()->id();
        $fileName =  $now . "_" . $userId . "_output_products_excel.xlsx";
        $url = "public/" . $fileName;
        dispatch(new OutputProductExcelUploadJob($url,$startDate, $endDate));

        return response()->json([
            'message' => "Chiqim qilingan mahsulotlar excelga yuklandi",
            'file_url' => "http://192.168.13.161:8002/storage/" . $fileName
        ], 200);
    }
    public function ProductDetailsExcel()
    {
        // if (!($this->check('upload_excel', 'report'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
        $startDate = request('start_date');
        $endDate = request('end_date');

        $now = date("Y_m_d_H_i_s");
        $userId = auth()->id();
        $fileName =  $now . "_" . $userId . "_product_details_excel.xlsx";
        $url = "public/" . $fileName;

        dispatch(new ProductDetailExcelUploadJob($url,$startDate, $endDate));

        return response()->json([
            'message' => "Do'kondagi Mahsulotlar qoldig'i excelga yuklandi",
            'file_url' => "http://192.168.13.161:8002/storage/" . $fileName
        ], 200);
    }
    public function BenefitsExcel()
    {
        // if (!($this->check('upload_excel', 'report'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
        $startDate = request('start_date');
        $endDate = request('end_date');

        $now = date("Y_m_d_H_i_s");
        $userId = auth()->id();
        $fileName =  $now . "_" . $userId . "_benefits_excel.xlsx";
        $url = "public/" . $fileName;
        dispatch(new BenefitExcelUploadJob($url,$startDate, $endDate));

        return response()->json([
            'message' => "Do'kondan qilingan foydalar excelga yuklandi",
            'file_url' => "http://192.168.13.161:8002/storage/" . $fileName
        ], 200);
    }
}
