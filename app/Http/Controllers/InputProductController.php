<?php

namespace App\Http\Controllers;

use App\Http\Requests\InputProductRequest;
use App\Http\Resources\UniversalResource;
use App\Interfaces\InputProductInterface;
use App\Models\Currency;
use App\Models\InputProduct;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InputProductController extends Controller
{
    public function __construct(protected InputProductInterface $inputProductInterfaceRepo) {}
    public function index()
    {
       return $this->inputProductInterfaceRepo->index();
    }
    public function store(InputProductRequest $request)
    {

        // InputProduct::factory()->create()->count(100000);
        // return 4;

        // if (!($this->check('product', 'add'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
        
        return $this->inputProductInterfaceRepo->store($request);
    }
}
