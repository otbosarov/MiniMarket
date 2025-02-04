<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
             'category_raise' => 'required|integer|between:1,100'
        ];
    }
    public function messages(){
        return [
            'category_raise.required' => "Kategoriya ustamani kiriting ",
            'category_raise.integer' => "Kategoriya ustama butun son bo'lishi kerak",
            'category_raise.between' => "Kategoriya ustama 1 dan 100 gacha bo'lgan sonlarni qabul qiladi "
        ];
    }
}
