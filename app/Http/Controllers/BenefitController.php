<?php

namespace App\Http\Controllers;

use App\Http\Resources\UniversalResource;
use App\Models\Benefit;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    public function index()
    {
        if(!($this->check('benefit','show'))){
            return response()->json(['message' => "Amaliyotga huquq yo'q"],403);
        }
        $perPage = request('per_page', 15);
        $search = request('search');
        $startDate = request('startDate');
        $endDate = request('endDate');

        $benefit = Benefit::join('products', 'benefits.product_id', 'products.id')
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
            ->when($search, function ($q) use ($search) {
                $q->where(function($query) use ($search) {
                    $query->where('products.product_name', 'ILIKE', "%$search%")
                        ->orWhere('categories.category_title', 'ILIKE', "%$search%");
                });
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereDate('benefits.created_at', '>=', $startDate)
                    ->whereDate('benefits.created_at', '<=', $endDate);
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
        return UniversalResource::collection($benefit);
    }
}
