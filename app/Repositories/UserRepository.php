<?php

namespace App\Repositories;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);
        $token  =  $user->createToken('auth-sanctum')->plainTextToken;
        return response()->json([
            'message' => "Siz muvaffaqiyatli ro'yhatdan o'tdingiz!",
            'token' => $token
        ], 201);
    }
    public function login(UserLoginRequest $request)
    {
        if (strlen($request->username) == 0 || strlen($request->password) == 0)
            return 'error';

        $user = User::where('username', $request->get('username'))->first();
        if (!$user)
            return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);
        if (!Hash::check($request->get('password'), $user->password))
            return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);

        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json(["token" => $token], 200);
    }
    public function update(UserUpdateRequest $request, $id)
    {
        $user =  User::where('id', $id)->first();
        $user->update([
            'full_name' => $request->full_name  ?? $user->full_name,
            'password' => $request->password  ?? $user->password,
            'phone' => $request->phone  ?? $user->phone,
        ]);
        return response()->json(['message' => "Ma'lumot yangilandi"], 200);
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => "Bu $id li user topilmadi"], 404);
        }
        $user->delete();
        return response()->json([
            'message' => "Ma'lumot o'chirildi",
            'delete' => $user
        ], 200);
    }
    public function changeActive($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => "Bu $id li ma'lumot topilmadi"], 404);
        }
        $user->active = !$user->active;
        $user->save();
        return response()->json(['message' => "Amaliyot bajarildi"], 200);
    }
    public function index()
    {
        return User::get();
    }
    public function userInfo()
    {
        return auth()->user();
    }
}
