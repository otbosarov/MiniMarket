<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Interfaces\SupplierInterface;
use App\Models\Supplier;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class SupplierController extends Controller
{
    public function __construct(protected SupplierInterface $supplierInterfaceRepo) {}
    public function index()
    {
        return  $this->supplierInterfaceRepo->index();
    }
    public function store(SupplierRequest $request)
    {
        if (!($this->check('supplier', 'add'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
        return $this->supplierInterfaceRepo->store($request);
    }
    public function update(SupplierUpdateRequest $request, $id)
    {
        if (!($this->check('supplier', 'edit'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
       return $this->supplierInterfaceRepo->update($request,$id);
    }
    public function destroy($id)
    {
        if (!($this->check('supplier', 'delete'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
        return $this->supplierInterfaceRepo->destroy($id);
    }
    public function changeAtive($id)
    {
        if (!($this->check('supplier', 'edit'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
       return $this->supplierInterfaceRepo->changeAtive($id);
    }
}
