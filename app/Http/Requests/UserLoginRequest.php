<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|min:3|max:60|unique:users,username',
            'password' => 'required|string|min:4|max:150',
        ];
    }
    public function messages()
    {
        return [
            'username.required' => "Username kiriting",
            'username.string' => "Username ni matn ko'rinishda kiriting",
            'username.min' => "Username kamida 3 ta belgidan iborat bo'lsin",
            'username.max' => "Username 60 ta belgidan belgidan oshmasligi kerak",
            'username.unique' => "Bu username avval yaratilgan",

            'password.required' => 'Parol kiriting',
            'password.string' => "Parolni matn ko'rinishda kiriting",
            'password.min' =>  "Parol kamida 4 ta belgidan iborat bo'lishi kerak",
            'password.max' => "Parol 150 ta belgidan oshmasligi kerak ",
        ];
    }
}
