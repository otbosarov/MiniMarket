<?php
namespace App\Repositories;

use App\Interfaces\SupplierInterface;
use App\Models\Supplier;

class SupplierRepository implements SupplierInterface{
    public function index()
    {
        return  Supplier::get();
    }
    public function store($request)
    {
        try {
            Supplier::create([
                'full_name' => $request->full_name,
                'title' => $request->title,
                'user_id' => auth()->id()
            ]);
            return response()->json(['message' => "Yangi ta'minotchi yaratildi"], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => "Ta'minotchi yaratishda xatolik sodir bo'ldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 500);
        }
    }
    public function update($request, $id)
    {
        $supplier = Supplier::where('id', $id)->first();
        if (!$supplier) {
            return response()->json(['message' => "Bunday ma'lumot topilmadi"], 404);
        }
        $supplier->update([
            'title' => $request->title ?? $supplier->title,
            'user_id' => auth()->id()
        ]);
        return response()->json(['message' => "Ma'lumot yangilandi"], 200);
    }
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['message' => "Bu $id li ma'lumot mavjud emas"], 404);
        }
        $supplier->delete();
        return response()->json([
            'message' => "Ma'lumot o'chirildi",
            'delete' => $supplier
        ], 200);
    }
    public function changeAtive($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['message' => "Bu $id li ma'lummot topilmadio"], 404);
        }
        $supplier->active = !$supplier->active;
        $supplier->save();
        return response()->json(['message' => "Amaliyot bajarildi "], 200);
    }
}
