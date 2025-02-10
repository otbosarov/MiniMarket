<?php

namespace App\Http\Api;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

class UserApi
{
    public static function route()
    {
        Route::controller(UserController::class)->group(function () {
            Route::put('user_update/{id}', 'update');
            Route::delete('user_delete/{id}', 'destroy');
            Route::put('user_changeActive/{id}', 'changeActive');
            Route::get('users_show', 'index');
            Route::get('get_profil', 'userInfo');
        });
    }
}
