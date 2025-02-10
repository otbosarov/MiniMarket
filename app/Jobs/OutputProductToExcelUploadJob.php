<?php

namespace App\Jobs;

use App\Exports\OutputProductExport;
use App\Models\OutputProduct;
use App\Models\UploadExcel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class OutputProductToExcelUploadJob implements ShouldQueue
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

        $uploadExcel =  UploadExcel::where('id', $uploadExcel_id)->first();

        try {

            $now = date("Y_m_d_H_i_s");

            $fileName = $now . $userId . "_output_products_excel.xlsx";
            $url = "public/" . $fileName;

            $outputProduct = OutputProduct::join('products', 'output_products.product_id', 'products.id')
                ->join('categories', 'products.category_id', 'categories.id')
                ->join('unities', 'output_products.unity_id', 'unities.id')
                ->join('users', 'output_products.user_id', 'users.id')
                ->select(
                    'output_products.id',
                    'products.product_name',
                    'unities.title',
                    'categories.category_title',
                    'output_products.amount',
                    'output_products.currency_type',
                    'output_products.currency_rate',
                    'output_products.output_price',
                    'output_products.created_at',
                    'users.full_name'
                )
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    $query->whereDate('output_products.created_at', '>=', $startDate)
                        ->whereDate('output_products.created_at', '<=', $endDate);
                })
                ->get();

            Excel::store(new OutputProductExport($outputProduct), $url);

            $uploadExcel->update([
                'status' => UploadExcel::STATUS_COMPLETED,
                'url' => $fileName,
            ]);
        } catch (\Exception $exception) {
            Log::error('Excel yaratishda xatolik' . $exception->getMessage());
            $uploadExcel->update([
                'status' => UploadExcel::STATUS_FAILED
            ]);
        }
    }
}
