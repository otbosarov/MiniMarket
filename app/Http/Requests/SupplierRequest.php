<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'title' => 'required|string|min:4|max:100|unique:suppliers,title',
            'full_name' => 'required|string|min:3|max:60|regex:/^[A-Za-z\'\s]+$/',
        ];
    }
    public function messages(){
        return [
            'title.required' => ' Kategoriya nomini kiriting',
            'title.string' => " Kategoriya nomi matn ko'rinishda kiriting",
            'title.min' => " Kategoriya nomi kamida 4 ta belgidan iborat bo'lsin",
            'title.max' => " Kategoriya nomi 150 ta belgidan oshmasligi kerak",
            'title.unique' => "Bu katagoriya avval yaratilgan",

            'full_name.required' => 'Ism kiriting',
            'full_name.string' => 'Ismni matn ko\'rinishda kiriting',
            'full_name.min' => "Ism kamida 3 belgidan iborat bo'lsin",
            'full_name.max' => "Ism 60 ta belgidan oshmasligi kerak",
            'full_name.regex' => "Ism faqat lotin harflardan iborat bo'lsin",
        ];
    }
}
