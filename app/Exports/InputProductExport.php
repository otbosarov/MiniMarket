<?php

namespace App\Exports;

use App\Models\InputProduct;
use Maatwebsite\Excel\Concerns\FromCollection;

class InputProductExport implements FromCollection
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
            'input_products.id' => "ID",
            'products.product_name' => "Mahsulot nomi",
            'unities.title' => "Birlik",
            'categories.category_title' => "Kategoriya",
            'input_products.amount' => "Miqdori",
            'input_products.currency_type' => "Valyuta turi",
            'input_products.currency_rate' => "Kurs",
            'input_products.input_price' => "Kirim narxi",
            'input_products.selling_price' => "Sotish narxi",
            'suppliers.title as supplier_name' => "Ta'minotchi nomi",
            'input_products.created_at' => "Kirim qilingan sana",
            'users.full_name' => "Kirim qilgan shaxs",
        ]);
    }
}
