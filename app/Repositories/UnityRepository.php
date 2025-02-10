<?php
namespace App\Repositories;

use App\Interfaces\UnityInterface;
use App\Models\Unity;

 class UnityRepository  implements UnityInterface{
    public function index()
    {
        return Unity::get();
    }
    public function store($request)
    {
        try {
            Unity::create([
                'title' => $request->title,
                'user_id' => auth()->id()
            ]);
            return response()->json(['message' => "Yangi o'lchov birlik yaratildi"], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => "Birlik yaratishda xatolik sodir bo'ldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 500);
        }
    }
    public function update($id)
    {
        $unity = Unity::where('id', $id)->first();
        if (!$unity) {
            return response()->json(['message' => "Bu $id li ma'lumot topilmadi"], 404);
        }
        $unity->active = !$unity->active;
        $unity->save();

        return response()->json(['message' => "Amaliyot bajarildi"], 200);
    }
    public function destroy($id)
    {
        $unity = Unity::find($id);
        if (!$unity) {
            return response()->json(['message' => "Bu $id li ma'lumot mavjud emas"], 404);
        }
        $unity->delete();
        return response()->json([
            'message' => "Ma'lumot o'chirildi",
            'delete' => $unity
        ], 200);
    }
 }
