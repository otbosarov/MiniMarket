<?php

namespace App\Exports;

use App\Models\ProductDetail;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductDetailExport implements FromCollection
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
            'product_details.id' => "ID",
            'products.product_name' => "Mahsulot nomi",
            'unities.title' => "Birlik",
            'categories.category_title' => "Kategoriya",
            'categories.category_raise' => "Ustama",
            'product_details.currency_type' => "Valyuta turi",
            'product_details.currency_rate' => "Kurs",
            'product_details.input_price' => "Kirim narxi",
            'product_details.selling_price' => "Sotish narxi",
            'product_details.residue' => "Qoldiq"
        ]);
    }
}
