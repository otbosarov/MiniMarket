<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'category_title' => 'required|string|min:3|max:100|unique:categories,category_title',
            'category_raise' => 'required|integer|between:1,100'
        ];
    }
    public function messages()
    {
        return [
            'category_title.required' => ' Kategoriya nomini kiriting',
            'category_title.string' => " Kategoriya nomi matn ko'rinishda kiriting",
            'category_title.min' => " Kategoriya nomi kamida 3 ta belgidan iborat bo'lsin",
            'category_title.max' => " Kategoriya nomi 150 ta belgidan oshmasligi kerak",
            'category_title.unique' => "Bu katagoriya avval yaratilgan",

            'category_raise.required' => "Kategoriya ustamani kiriting ",
            'category_raise.integer' => "Kategoriya ustama butun son bo'lishi kerak",
            'category_raise.between' => "Kategoriya ustama 1 dan 100 gacha bo'lgan sonlarni qabul qiladi "
        ];
    }
}
