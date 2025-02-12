<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutputProductRequest;
use App\Http\Resources\UniversalResource;
use App\Models\Benefit;
use App\Models\Currency;
use App\Models\OutputProduct;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class OutputProductController extends Controller
{
    public function index()
    {
        $perPege = request('per_page', 15);
        $search = request('search');
        $startDate = request('startDate');
        $endDate = request('endDate');

        $output = OutputProduct::join('products', 'output_products.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('unities', 'output_products.unity_id', 'unities.id')
            ->join('users', 'output_products.user_id', 'users.id')
            ->select(
                'output_products.id',
                'products.product_name',
                'unities.title',
                'categories.category_title',
                'output_products.amount',
                'output_products.currency_type',
                'output_products.output_price',
                'output_products.created_at',
                'users.full_name'
            )
            ->when($search, function ($query) use ($search) {
            $query->where(function($q)use($search){
                 $q->where('products.product_name', 'ILIKE', "%$search%")
                     ->orWhere('categories.category_title', 'ILIKE', "%$search%");
            });
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereDate('output_products.created_at', '>=', $startDate)
                    ->whereDate('output_products.created_at', '<=', $endDate);
            })
            ->orderBy('id', 'desc')
            ->paginate($perPege);
        return UniversalResource::collection($output);
    }
    public function store(OutputProductRequest $request)
    {
        if(!($this->check('product','add'))){
            return response()->json(['message'=>"Amaliyot uchun huquq yo'q"],403);
        }
        $detail = ProductDetail::where('product_id', $request->product_id)->first();
        if (!$detail) {
            return response()->json(['message' => "Bunday mahsulot topilmadi"], 404);
        }
        $sellingPrice = $detail->selling_price;
        $unity = $detail->unity_id;
        $currency_type = $detail->currency_type;
        $rateDetail = $detail->currency_rate;
        $input_price = $detail->input_price;
        $selling_price = $detail->selling_price;
        $resuideDetail = $detail->residue;

        DB::beginTransaction();
        try {
            $currency = Currency::where('endDate', null)
                ->where('active', true)
                ->orderBy('id', 'desc')->first();
            $rate = $currency->rate;

            if ($request->amount > $resuideDetail) {
                return response()->json(['message' => "Qoldiq yetarli emas"], 422);
            }
            $totalResidue = $resuideDetail - $request->amount;

            $USD = ($request->currency_type == 'USD');
            $USDPrice = $sellingPrice / $rate;
            $UZSPrice = $sellingPrice;

            OutputProduct::create([
                'product_id' => $request->product_id,
                'unity_id' => $unity,
                'amount' => $request->amount,
                'currency_type' => $request->currency_type,
                'currency_rate' => $rate,
                'output_price' => $USD ? $USDPrice : $UZSPrice,
                'user_id' => auth()->id()
            ]);

            $detail->update(['residue' => $totalResidue]);

            $USD = ($currency_type == 'USD');
            $USDPrice = $input_price * $rateDetail;
            $UZSPrice = $input_price;

            Benefit::create([
                'product_id' => $request->product_id,
                'unity_id' => $unity,
                'amount' => $request->amount,
                'currency_type' => $currency_type,
                'currency_rate' => $rateDetail,
                'input_price' => $input_price,
                'selling_price' => $selling_price,
                'proceed_price' => ($selling_price - ($USD ? $USDPrice : $UZSPrice)) * $request->amount
            ]);
            DB::commit();
            return response()->json(['message' => "Amaliyot bajarildi"], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => "Mahsulot chiqim qilishda xatolik sodir bo'ldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 500);
        }
    }
}
