<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnityRequest;
use App\Models\Unity;
use Illuminate\Http\Request;

class UnityController extends Controller
{
    public function index()
    {
        return Unity::get();
    }
    public function store(UnityRequest $request)
    {
        if (!($this->check('unity', 'add'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
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
        if (!($this->check('unity', 'edit'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
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
        if (!($this->check('unity', 'delete'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
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
