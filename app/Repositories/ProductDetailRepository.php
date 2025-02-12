<?php

namespace App\Repositories;

use App\Http\Resources\UniversalResource;
use App\Interfaces\ProductDetailInterface;
use App\Models\ProductDetail;

class ProductDetailRepository implements ProductDetailInterface
{
    public function index()
    {
        $perPage = request('per_page', 15);
        $search = request('search');

        $detail = ProductDetail::join('products', 'product_details.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('unities', 'product_details.unity_id', 'unities.id')
            ->select(
                'product_details.id',
                'products.product_name',
                'unities.title',
                'categories.category_title',
                'categories.category_raise',
                'product_details.currency_type',
                'product_details.input_price',
                'product_details.selling_price',
                'product_details.residue'
            )
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('products.product_name', 'ILIKE', "%$search%")
                        ->orWhere('categories.category_title', 'ILIKE', "%$search%");
                });
            })
            ->simplePaginate($perPage);
        return UniversalResource::collection($detail);
    }
    public function update($request, $id)
    {
        $detail = ProductDetail::where('id', $id)->first();
        if (!$detail) {
            return response()->json(['message' => "Qoldiqda bunday mahsulot mavjud emas"], 404);
        }
        $raise = $detail->raise;
        $currency = $detail->currency_type;
        $rate = $detail->currency_rate;
        $input = $detail->input_price;

        $USD = ($currency == 'USD');
        $USDPrice = (($input) * $rate) * (($request->raise / 100) + 1);
        $UZSPrice = ($input) * (($request->raise / 100) + 1);

        $detail->update([
            'raise' => $request->raise,
            'selling_price' => $USD ? $USDPrice : $UZSPrice
        ]);
    }
}
