<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
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
        ];
    }
    public function messages()
    {
        return [
            'title.required' => ' Kategoriya nomini kiriting',
            'title.string' => " Kategoriya nomi matn ko'rinishda kiriting",
            'title.min' => " Kategoriya nomi kamida 4 ta belgidan iborat bo'lsin",
            'title.max' => " Kategoriya nomi 150 ta belgidan oshmasligi kerak",
            'title.unique' => "Bu katagoriya avval yaratilgan",
        ];
    }
}
