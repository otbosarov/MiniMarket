<?php
namespace App\Repositories;

use App\Http\Resources\UniversalResource;
use App\Interfaces\ProductDetailInterface;
use App\Models\Product;

class ProductRepository implements ProductDetailInterface{
    public function index()
    {
        $perPage = request('per_page', 15);
        $search = request('search');

        $product = Product::join('categories', 'products.category_id', 'categories.id')
            ->join('users', 'products.user_id', 'users.id')
            ->select(
                'products.id',
                'products.product_name',
                'categories.category_title',
                'users.full_name',
                'products.active'
            )
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('products.product_name', 'ILIKE', "%$search%")
                        ->orWhere('categories.category_title', 'ILIKE', "%$search%");
                });
            })
            ->paginate($perPage);
        return UniversalResource::collection($product);
    }
    public function store( $request)
    {
        try {
            Product::create([
                'product_name' => $request->product_name,
                'category_id' => $request->category_id,
                'user_id' => auth()->id()
            ]);
            return response()->json(['message' => "Yangi mahsulot yaratildi"], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => "Mahsulot yaratishda xatolik sodir bo'ldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile()
            ], 500);
        }
    }
    public function update($request, $id)
    {
         $product = Product::where('id', $id)->first();
        if (!$product) {
            return response()->json(['message' => "Bu $id li ma'lumot topilmadi"], 404);
        }
        $product->update([
            'category_id' => $request->category_id ?? $product->category_id,
            'user_id' => auth()->id()
        ]);
        return response()->json(['message' => "Ma'lumot yangilandi"], 200);
    }
    public function destroy($id)
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return response()->json(['message' => "Bu $id li ma'lumot topilmadi"], 404);
        }
        $product->delete();
        return response()->json([
            'message' => "Ma'lumot o'chirildi",
            'delete' => $product
        ], 200);
    }
    public function changeActive($id)
    {
        $product  = Product::find($id);
        if (!$product) {
            return response()->json(['message' => "Bu $id li ma'lumot topilmadi"], 404);
        }
        $product->active  = !$product->active;
        $product->save();
        return response()->json(['message' => "Amaliyot bajarildi"], 200);
    }
}
