<?php

namespace App\Http\Controllers;

use App\Exports\InputProductExport;
use App\Jobs\BenefitExcelUploadJob;
use App\Jobs\BenefitToExcelUploadJob;
use App\Jobs\InputProductExcelUploadJob;
use App\Jobs\InputProductToExcelUploadJob;
use App\Jobs\OutputProductExcelUploadJob;
use App\Jobs\OutputProductToExcelUploadJob;
use App\Jobs\ProductDetailExcelUploadJob;
use App\Jobs\ProductDetailToExcelUploadJob;
use App\Models\InputProduct;
use App\Models\ProductDetail;
use App\Models\UploadExcel;
use Maatwebsite\Excel\Facades\Excel;

class UploadToExcelController extends Controller
{
    public function InputProductsExcel()
    {
        // if (!($this->check('upload_excel', 'report'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
        $startDate = request('start_date', now()->startOfMonth()->toDateString());
        $endDate = request('end_date', now()->toDateString());

        $userId = auth()->user()->id;

        $uploadExcel = UploadExcel::create([
            'user_id' => $userId,
            'status' => UploadExcel::STATUS_PROCESSING,
            'file_name' => "Kirim"
        ]);
        $datas = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_id' => $userId,
            'uploadExcel_id' => $uploadExcel->id,
        ];

        dispatch(new InputProductToExcelUploadJob($datas));

        return response()->json([
            'message' => "Kirim qilingan mahsulotlar excelga yuklash jaroyonida",
        ], 200);
    }
    public function OutputProductsExcel()
    {
        // if (!($this->check('upload_excel', 'report'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }

        $startDate = request('start_date', now()->startOfMonth()->toDateString());
        $endDate = request('end_date', now()->toDateString());

        $userId = auth()->user()->id;

        $uploadExcel = UploadExcel::create([
            'user_id' => $userId,
            'status' => UploadExcel::STATUS_PROCESSING,
            'file_name' => "Chiqim",
        ]);

        $datas = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_id' => $userId,
            'uploadExcel_id' => $uploadExcel->id
        ];

        dispatch(new OutputProductToExcelUploadJob($datas));

        return response()->json([
            'message' => "Chiqim qilingan mahsulotlar excelga yuklash jarayonda",
        ], 200);
    }
    public function ProductDetailsExcel()
    {
        // if (!($this->check('upload_excel', 'report'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }

        $startDate = request('start_date', now()->startOfMonth()->toDateString());
        $endDate = request('end_date', now()->toDateString());

        $userId = auth()->user()->id;

        $uploadExcel = UploadExcel::create([
            'user_id' => $userId,
            'status' => UploadExcel::STATUS_PROCESSING,
            'file_name' => "Qoldiq",
        ]);

        $datas = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_id' => $userId,
            'uploadExcel_id' => $uploadExcel->id
        ];

        dispatch(new ProductDetailToExcelUploadJob($datas));

        return response()->json([
            'message' => " Mahsulotlar qoldig'i excelga yuklash jarayonda ",
        ], 200);
    }
    public function BenefitsExcel()
    {
        // if (!($this->check('upload_excel', 'report'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }

        $startDate = request('start_date', now()->startOfMonth()->toDateString());
        $endDate = request('end_date', now()->toDateString());

        $userId = auth()->id();

        $uploadExcel = UploadExcel::create([
            'user_id' => $userId,
            'status' => UploadExcel::STATUS_PROCESSING,
            'file_name' => "Foyda",
        ]);

        $datas = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_id' => $userId,
            'uploadExcel_id' => $uploadExcel->id
        ];

        dispatch(new BenefitToExcelUploadJob($datas));

        return response()->json([
            'message' => "Do'kondan qilingan foydalar excelga yulash  jarayonda",
        ], 200);
    }
}
