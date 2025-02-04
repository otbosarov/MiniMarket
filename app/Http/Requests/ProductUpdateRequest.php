<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
             'category_id' => 'required|integer|exists:categories,id'
        ];
    }
    public function messages(){
        return [
            'category_id.required' => "Kategoriya ID ni kiriting",
            'category_id.integer' => "Kategoriya ID raqam  ko'rinishda kiriting",
            'category_id.exists' => "Bu kategoriya ID kategoriyalar jadvalida mavjud emas"
        ];
    }
}
