<?php

namespace App\Jobs;

use App\Exports\InputProductExport;
use App\Models\InputProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class InputProductExcelUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private $url, private $startDate, private $endDate)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       // sleep(80);
        $url = $this->url;
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        // Log::error($endDate);
        // Log::error($startDate);
        // Log::error($url);
        $data = InputProduct::join('products', 'input_products.product_id', 'products.id')
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
        Excel::store(new InputProductExport($data), $url);
    }
}
