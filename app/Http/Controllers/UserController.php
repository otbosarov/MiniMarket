<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(protected UserInterface $userInterfaceRepo) {}
    public function register(UserRegisterRequest $request)
    {
        return $this->userInterfaceRepo->register($request);
    }
    public function login(UserLoginRequest $request)
    {
        return $this->userInterfaceRepo->login($request);
    }
    public function update(UserUpdateRequest $request, $id)
    {
         // if (!($this->check('user', 'edit'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
        return $this->userInterfaceRepo->update($request, $id);
    }
    public function destroy($id)
    {
          // if (!($this->check('user', 'delete'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
        return $this->userInterfaceRepo->destroy($id);
    }
    public function changeActive($id)
    {
        // if (!($this->check('user', 'edit'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
        return $this->userInterfaceRepo->changeActive($id);
    }
    public function index()
    {
        return $this->userInterfaceRepo->index();
    }
    public function userInfo()
    {
        return $this->userInterfaceRepo->userInfo();
    }
}
