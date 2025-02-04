<?php

namespace App\Exports;

use App\Models\OutputProduct;
use Maatwebsite\Excel\Concerns\FromCollection;

class OutputProductExport implements FromCollection
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
            'output_products.id' => "ID",
            'products.product_name' => "Mahsulot nomi",
            'unities.title' => "Birlik",
            'categories.category_title' => "Kategoriya",
            'output_products.amount' => "Miqdori",
            'output_products.currency_type' => "Valyuta turi",
            'output_products.currency_rate' => "Kurs",
            'output_products.output_price' => "Chiqim narxi",
            'output_products.created_at' => "Chiqim sanasi",
            'users.full_name' => "Chiqim qilgan shaxs"
        ]);
    }
}
