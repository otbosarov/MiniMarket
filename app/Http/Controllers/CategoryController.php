<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Interfaces\CategoriyaInterface;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoriyaInterface $categoriyaInterfaceRepo) {}
    public function index()
    {
        return $this->categoriyaInterfaceRepo->index();
    }
    public function store(CategoryRequest $request)
    {
        // if(!($this->check('category','add'))){
        //     return response()->json(['message'=>"Amaliyot uchun huquq yo'q"],403);
        // }
        return $this->categoriyaInterfaceRepo->store( $request);
    }
    public function update(CategoryUpdateRequest $request, $id)
    {
        // if (!($this->check('category', 'edit'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
        return $this->categoriyaInterfaceRepo->update($request,$id);
    }
    public function destroy($id)
    {
        // if (!($this->check('category', 'delete'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
       return $this->categoriyaInterfaceRepo->destroy($id);
    }
    public function changeActive($id)
    {
          // if (!($this->check('category', 'edit'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
       return $this->categoriyaInterfaceRepo->changeActive($id);
    }
}
