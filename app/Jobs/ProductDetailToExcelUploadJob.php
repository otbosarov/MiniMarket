<?php

namespace App\Jobs;

use App\Exports\ProductDetailExport;
use App\Models\ProductDetail;
use App\Models\UploadExcel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ProductDetailToExcelUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private $datas)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $startDate = $this->datas['start_date'];
        $endDate = $this->datas['end_date'];
        $userId = $this->datas['user_id'];
        $uploadExcel_id = $this->datas['uploadExcel_id'];

        $uploadExcel = UploadExcel::where('id', $uploadExcel_id)->first();

        try {
            $now = date("Y_m_d_H_i_s");
            $fileName = $now . $userId . "_product_details_excel.xlsx";
            $url = "public/" . $fileName;

            $productDetail = ProductDetail::join('products', 'product_details.product_id', 'products.id')
                ->join('categories', 'products.category_id', 'categories.id')
                ->join('unities', 'product_details.unity_id', 'unities.id')
                ->select(
                    'product_details.id',
                    'products.product_name',
                    'unities.title',
                    'categories.category_title',
                    'categories.category_raise',
                    'product_details.currency_type',
                    'product_details.currency_rate',
                    'product_details.input_price',
                    'product_details.selling_price',
                    'product_details.residue',
                )
                ->get();

            Excel::store(new ProductDetailExport($productDetail), $url);

            $uploadExcel->update([
                'status' => UploadExcel::STATUS_COMPLETED,
                'url' => $fileName,
            ]);
        } catch (\Exception $exception) {
            Log::error('Excel yuklashda xatolik' . $exception->getMessage());
            $uploadExcel->update([
                'status' => UploadExcel::STATUS_FAILED
            ]);
        }
    }
}
