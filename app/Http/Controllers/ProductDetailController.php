<?php

namespace App\Http\Controllers;

use App\Http\Resources\UniversalResource;
use App\Interfaces\ProductDetailInterface;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function __construct(protected ProductDetailInterface $productDetailInterfaceRepo){}
    public function index()
    {
       return $this->productDetailInterfaceRepo->index();
    }
    public function update(Request $request, $id)
    {
      return $this->productDetailInterfaceRepo->update($request,$id);
    }
}
