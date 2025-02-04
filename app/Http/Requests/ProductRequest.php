<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name' => 'required|string|min:3|max:255|unique:products,product_name',
            'category_id' => 'required|integer|exists:categories,id'
        ];
    }
    public function messages(){
        return [
            'product_name.required' => 'Mahsulot nomini kiriting',
            'product_name.string' => 'Mahsulot nomini matn ko\'rinishda kiriting',
            'product_name.min' => "Mahsulot nomi kamida 3 ta belgidan iborat bo'lsin",
            'product_name.max' => "Mahsulot nomi 255 ta beld=gidan oshmasligi kerak",
            'product_name.unique' => "Mahsulot nomi avval yaratilgan",

            'category_id.required' => "Kategoriya ID ni kiriting",
            'category_id.integer' => "Kategoriya ID raqam  ko'rinishda kiriting",
            'category_id.exists' => "Bu kategoriya ID kategoriyalar jadvalida mavjud emas"
        ];
    }
}
