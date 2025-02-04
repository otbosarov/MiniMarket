<?php

namespace App\Jobs;

use App\Exports\ProductDetailExport;
use App\Models\ProductDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ProductDetailExcelUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private $url,private $startDate,private $endDate)
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

        $data = ProductDetail::join('products', 'product_details.product_id', 'products.id')
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
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereDate('product_details.created_at', '>=', $startDate)
                    ->whereDate('product_details.created_at', '<=', $endDate);
            })
            ->get();
        Excel::store(new ProductDetailExport($data), $url);
    }
}
