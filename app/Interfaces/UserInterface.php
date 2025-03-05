<?php

namespace App\Interfaces;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;

interface UserInterface
{
    function register(UserRegisterRequest $request);
    function login(UserLoginRequest $request);
    function update(UserUpdateRequest $request, $id);
    function destroy($id);
    function changeActive(int $id);
    function index();
    function userInfo();
}
