<?php

namespace App\Exports;

use App\Models\Benefit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;

class BenefitExport implements FromCollection
{
    public function __construct(private $data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        return $this->data->prepend([
            'benefits.id' => "ID",
            'products.product_name' => "Mahsulot nomi",
            'unities.title' => "Birlik",
            'categories.category_title' => "Kategoriya",
            'benefits.amount' => "Miqdori",
            'benefits.currency_type' => "Valyuta turi",
            'benefits.currency_rate' => "Kurs",
            'benefits.input_price' => "Kirim narxi",
            'benefits.selling_price' => "Sotish narxi",
            'benefits.proceed_price' => "Foyda",
            'benefits.created_at' => "Foyda sanasi"
        ]);
    }
}
