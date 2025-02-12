<?php

namespace App\Jobs;

use App\Exports\InputProductExport;
use App\Models\InputProduct;
use App\Models\UploadExcel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class InputProductToExcelUploadJob implements ShouldQueue
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
            $fileName = $now . $userId . "_input_products_excel.xlsx";
            $url = "public/" . $fileName;

            $inputProducts = InputProduct::join('products', 'input_products.product_id', 'products.id')
                ->join('categories', 'products.category_id', 'categories.id')
                ->join('unities', 'input_products.unity_id', 'unities.id')
                ->join('users', 'input_products.user_id', 'users.id')
                ->join('suppliers', 'input_products.supplier_id', 'suppliers.id')
                ->select(
                    'input_products.id',
                    'products.product_name',
                    'unities.title',
                    'categories.category_title',
                    'input_products.amount',
                    'input_products.currency_type',
                    'input_products.currency_rate',
                    'input_products.input_price',
                    'input_products.selling_price',
                    'suppliers.title as supplier_name',
                    'input_products.created_at',
                    'users.full_name',
                )
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    $query->whereDate('input_products.created_at', '>=', $startDate)
                        ->whereDate('input_products.created_at', '<=', $endDate);
                })
                ->get();

            Excel::store(new InputProductExport($inputProducts), $url);

            $uploadExcel->update([
                'status' => UploadExcel::STATUS_COMPLETED,
                'url' => $fileName
            ]);
        } catch (\Exception $exception) {
            Log::error('Excel yaratishda xatolik' . $exception->getMessage());
            $uploadExcel->update([
                'status' => UploadExcel::STATUS_FAILED
            ]);
        }
    }
}
