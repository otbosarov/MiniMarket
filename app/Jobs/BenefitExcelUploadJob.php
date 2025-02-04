<?php

namespace App\Jobs;

use App\Exports\BenefitExport;
use App\Models\Benefit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class BenefitExcelUploadJob implements ShouldQueue
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

        $data = Benefit::join('products', 'benefits.product_id', 'products.id')
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
        Excel::store(new BenefitExport($data), $url);
    }
}
