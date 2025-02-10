<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProducts;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class InvoiceProductsController extends Controller
{
    public function index()
    {
        return InvoiceProducts::get();
    }
    public function store(Request $request)
    {
        $productData = $request->product_data;
        $productIds = collect($productData)->pluck('product_id');

        $details = ProductDetail::join('products', 'product_details.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('unities', 'product_details.unity_id', 'unities.id')
            ->whereIn('product_id', $productIds)
            ->get()
            ->keyBy('product_id')
            ->toArray();

        $insertData = [];
        $notProducts = "";
        $notResidue = "";

        foreach ($productData as $data) {
            if (!isset($details[$data['product_id']])) {
                $notProducts .= $data['product_id'] . ', ';
                continue;
            }
            if ($data['amount'] > $details[$data['product_id']]['residue']) {
                $notResidue .= $data['product_id'] . ',';
                continue;
            }
            $total_residue = $details[$data['product_id']]['residue'] - $data['amount'];

            $insertData[] = [
                'invoice_id' => $request->invoice_id,
                'product_id' => $data['product_id'],
                'unity' => $details[$data['product_id']]['title'],
                'amount' => $data['amount'],
                'currency_type' => $details[$data['product_id']]['currency_type'],
                'selling_price' => $details[$data['product_id']]['selling_price'],
                'status' => InvoiceProducts::STATUS_SOLD,
                'created_at' => now()
            ];

            ProductDetail::where('product_id', $data['product_id'])->update([
                'residue' => $total_residue
            ]);
        }

        if ($notProducts) {
            return response()->json([
                "message" => "[ $notProducts ] IDli tovar(lar) qoliqda mavjud emas!"
            ], 404);
        }
        if (!empty($notResidue)) {
            return response()->json([
                "message" => "[ $notResidue ] IDli mahsulot(lar)ning qoldig'i yetarli emas!"
            ], 400);
        }

        if (!empty($insertData)) {
            InvoiceProducts::insert($insertData);
        }
        foreach ($insertData as $insert) {
        }

            // $price = $product->selling_price;

            // $invoice = Invoice::where('id', $request->invoice_id)->first();
            // $invoice->update([
            //     'total_price' => $price
            // ]);

        ;


        return response()->json(["message" => 'Amaliyot bajarildi'], 201);
    }
}
