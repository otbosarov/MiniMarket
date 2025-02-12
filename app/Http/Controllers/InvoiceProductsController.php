<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProducts;
use App\Models\ProductDetail;
use App\Services\MonthDaysService;
use Illuminate\Http\Request;

class InvoiceProductsController extends Controller
{
    use MonthDaysService;
    public function index(int $id): mixed
    {
        $data = Invoice::with(
             'invoice_user:id,full_name',
            'invoice_products.product.category',
        )
            ->select('id', 'currency_type', 'user_id', 'total_price', 'created_at')
            ->where('invoices.id', $id)
            ->first();

        if (!$data) {
            return response()->json(['message' => "Bu $id li faktura topilmadi!"], 404);
        }

        return $data;
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
        $now = date('Y-m-d H:i:s');

        $total_value = 0;

        foreach ($productData as $data) {
            if (!isset($details[$data['product_id']])) {
                $notProducts .= $data['product_id'] . " ";
                continue;
            }
            if ($data['amount'] > $details[$data['product_id']]['residue']) {
                $notResidue .= $data['product_id'];
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
                'created_at' => $now
            ];
            $total_value += $details[$data['product_id']]['selling_price'] * $data['amount'];

            ProductDetail::where('product_id', $data['product_id'])->update([
                'residue' => $total_residue
            ]);
        }

        if ($notProducts) {
            return response()->json([
                "message" => "[ $notProducts ] IDli tovar(lar) mavjud emas!"
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

        $invoice = Invoice::where('id', $request->invoice_id)->first();
        $invoice->update([
            'total_price' => $total_value
        ]);

        return response()->json(["message" => 'Amaliyot bajarildi'], 201);
    }
}
