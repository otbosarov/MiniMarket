<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::get();
    }
    public function store(CategoryRequest $request)
    {
        if(!($this->check('category','add'))){
            return response()->json(['message'=>"Amaliyot uchun huquq yo'q"],403);
        }
        try {
            Category::create([
                'category_title' => $request->category_title,
                'category_raise' => $request->category_raise,
                'user_id' => auth()->id()
            ]);
            return response()->json(['message' => "Yangi kategoriya yaratildi"], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => "Ketogoriya yaratishda xatolik sodir bo'ldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 500);
        }
    }
    public function update(CategoryUpdateRequest $request, $id)
    {
        if (!($this->check('category', 'edit'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
        $category = Category::where('id', $id)->first();
        if (!$category) {
            return response()->json(['message' => "Bu $id li ma'lumot mavjud emas"], 404);
        }
        try {
            $category->update([
                'category_raise' => $request->category_raise,
                'user_id' => auth()->id()
            ]);
            return response()->json(['message' => "Ma'lumot yangilandi"], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => "Ma'lumot yangilashda xatolik sodir bo'ldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 500);
        }
    }
    public function destroy($id)
    {
        if (!($this->check('category', 'delete'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => "Bu $id li ma'lumot topilmadi"], 404);
        }
        $category->delete();

        return response()->json([
            'message' => "Malumot o'chirildi",
            'delete' => $category
        ], 200);
    }
    public function changeActive($id)
    {
        if (!($this->check('category', 'edit'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => "Bu $id li ma'lumot topilmadi"], 404);
        }
        $category->active = !$category->active;
        $category->save();
        return response()->json(['message' => "Amaliyot bajarildi"], 200);
    }
}
