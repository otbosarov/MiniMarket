<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\UniversalResource;
use App\Interfaces\ProductInterface;
use App\Models\Currency;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductInterface $productInterfaceRepo){}
    public function index()
    {
      return $this->productInterfaceRepo->index();
    }
    public function store(ProductRequest $request)
    {
        if (!($this->check('product', 'add'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
       return $this->productInterfaceRepo->store($request);
    }
    public function update(ProductUpdateRequest $request, $id)
    {
        if (!($this->check('product', 'edit'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
        return $this->productInterfaceRepo->update($request,$id);
    }
    public function destroy($id)
    {
        if (!($this->check('product', 'delete'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
        return $this->productInterfaceRepo->destroy($id);
    }
    public function changeActive($id)
    {
        if (!($this->check('product', 'edit'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
      return $this->productInterfaceRepo->changeActive($id);
    }
}
