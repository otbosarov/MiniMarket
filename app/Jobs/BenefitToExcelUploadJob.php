<?php

namespace App\Jobs;

use App\Exports\BenefitExport;
use App\Models\Benefit;
use App\Models\UploadExcel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BenefitToExcelUploadJob implements ShouldQueue
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

        $uploadExcel = UploadExcel::where('id',$uploadExcel_id);

        try {
            $now = date("Y_m_d_H_i_s");

            $fileName = $now . "_" . $userId . "_benefits_excel.xlsx";
            $url = "public/" . $fileName;

            $benefit = Benefit::join('products', 'benefits.product_id', 'products.id')
                ->join('categories', 'products.category_id', 'categories.id')
                ->join('unities', 'benefits.unity_id', 'unities.id')
                ->select(
                    'benefits.id',
                    'products.product_name',
                    'unities.title',
                    'categories.category_title',
                    'benefits.amount',
                    'benefits.currency_type',
                    'benefits.currency_rate',
                    'benefits.input_price',
                    'benefits.selling_price',
                    'benefits.proceed_price',
                    'benefits.created_at'
                )
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    $query->whereDate('benefits.created_at', '>=', $startDate)
                        ->whereDate('benefits.created_at', '<=', $endDate);
                })
                ->get();

            Excel::store(new BenefitExport($benefit), $url);

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
