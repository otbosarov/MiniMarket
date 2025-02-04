<?php

namespace App\Jobs;

use App\Exports\OutputProductExport;
use App\Models\OutputProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class OutputProductExcelUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private $url,private $startDate, private $endDate)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = $this->url;
        $startDate = $this->startDate;
        $endDate = $this->endDate;

        $data = OutputProduct::join('products', 'output_products.product_id', 'products.id')
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
        Excel::store(new OutputProductExport($data), $url);
    }
}
