<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'full_name' => 'required|string|min:3|max:60|regex:/^[A-Za-z\'\s]+$/',
            'username' => 'required|string|min:3|max:60|unique:users,username',
            'password' => 'required|string|min:4|max:150',
            'phone' => 'required|string|starts_with:+998|size:17|unique:users,phone'
        ];
    }
    public function messages()
    {
        return [
            'full_name.required' => 'Ism kiriting',
            'full_name.string' => 'Ismni matn ko\'rinishda kiriting',
            'full_name.min' => "Ism kamida 3 belgidan iborat bo'lsin",
            'full_name.max' => "Ism 60 ta belgidan oshmasligi kerak",
            'full_name.regex' => "Ism faqat lotin harflardan iborat bo'lsin",

            'username.required' => "Username kiriting",
            'username.string' => "Username ni matn ko'rinishda kiriting",
            'username.min' => "Username kamida 3 ta belgidan iborat bo'lsin",
            'username.max' => "Username 60 ta belgidan belgidan oshmasligi kerak",
            'username.unique' => "Bu username avval yaratilgan",

            'password.required' => 'Parol kiriting',
            'password.string' => "Parolni matn ko'rinishda kiriting",
            'password.min' =>  "Parol kamida 4 ta belgidan iborat bo'lishi kerak",
            'password.max' => "Parol 150 ta belgidan oshmasligi kerak ",

            'phone.required' => 'Telefon raqamini kiritish majburiy!',
            'phone.starts_with' => 'Telefon raqami +998 bilan boshlanishi kerak.',
            'phone.size' => 'Telefon raqami uzunligi 17 ta belgidan iborat bo\'lishi kerak.',
            'phone.unique' => 'Bu raqamli avval ro\'yhatdan o\'tgan',

        ];
    }
}
