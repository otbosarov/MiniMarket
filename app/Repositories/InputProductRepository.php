<?php

namespace App\Repositories;

use App\Http\Resources\UniversalResource;
use App\Interfaces\InputProductInterface;
use App\Models\Currency;
use App\Models\InputProduct;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\DB;

class InputProductRepository implements InputProductInterface
{
    public function index()
    {
        $perPage = request('per_page', 15);
        $search = request('search');
        $startDate = request('startDate');
        $endDate = request('endDate');

        $input = InputProduct::join('products', 'input_products.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('unities', 'input_products.unity_id', 'unities.id')
            ->join('users', 'input_products.user_id', 'users.id')
            ->join('suppliers', 'input_products.supplier_id', 'suppliers.id')
            ->select(
                'input_products.id',
                'products.product_name',
                'unities.title',
                'categories.category_title',
                'input_products.amount',
                'input_products.currency_type',
                'input_products.currency_rate',
                'input_products.input_price',
                'input_products.selling_price',
                'suppliers.title as supplier_name',
                'input_products.created_at',
                'users.full_name',
            )
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('products.product_name', 'ILIKE', "%$search%")
                        ->orWhere('categories.category_title', 'ILIKE', "%$search%")
                        ->orWhere('suppliers.title', 'ILIKE', "%$search%");
                });
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereDate('input_products.created_at', '>=', $startDate)
                    ->whereDate('input_products.created_at', '<=', $endDate);
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
        return UniversalResource::collection($input);
    }
    public function store($request)
    {
        
        $product = Product::where('products.id', $request->product_id)

            ->join('categories', 'products.category_id', 'categories.id')
            ->where('products.active', true)
            ->select('products.id', 'products.product_name', 'categories.category_title', 'categories.category_raise',)
            ->first();
        if (!$product) {
            return response()->json(['message' => "Bunday mahsulot topilmadi "], 404);
        }
        $raise = $product->category_raise;
        DB::beginTransaction();
        try {
            $currency = Currency::where('active', true)
                ->where('endDate', null)
                ->orderBy('id', 'desc')
                ->first();
            $rate = $currency->rate;

            $detail = ProductDetail::where('product_details.product_id', $request->product_id)->first();

            $USD = ($request->currency_type == 'USD');
            $USDPrice = (($request->input_price) * $rate) * (($raise / 100) + 1);
            $UZSPrice = ($request->input_price) * (($raise / 100) + 1);

            InputProduct::create([
                'product_id' => $request->product_id,
                'unity_id' => $request->unity_id,
                'amount' => $request->amount,
                'supplier_id' => $request->supplier_id,
                'currency_type' => $request->currency_type,
                'currency_rate' => $rate,
                'input_price' => $request->input_price,
                'selling_price' => $USD ? $USDPrice : $UZSPrice,
                'user_id' => auth()->id()
            ]);

            if ($detail) {
                $detail->update([
                    'currency_type' => $request->currency_type,
                    'currency_rate' => $rate,
                    'input_price' => $request->input_price,
                    'selling_price' => $USD ? $USDPrice : $UZSPrice,
                    'residue' => $detail->residue + $request->amount,
                    'user_id' => auth()->id()
                ]);
            } else {
                ProductDetail::create([
                    'product_id' => $request->product_id,
                    'unity_id' => $request->unity_id,
                    'raise' => $raise,
                    'currency_rate' => $rate,
                    'currency_type' => $request->currency_type,
                    'input_price' => $request->input_price,
                    'selling_price' => $USD ? $USDPrice : $UZSPrice,
                    'residue' => $request->amount,
                    'user_id' => auth()->id()
                ]);
            }
            DB::commit();
            return response()->json(['message' => "Amaliyot bajarildi"], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => "Mahsulot kirim qilishda xatolik sodir bo'ldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile()
            ], 500);
        }
    }
}
