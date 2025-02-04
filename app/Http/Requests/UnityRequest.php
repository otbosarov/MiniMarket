<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnityRequest extends FormRequest
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
            'title' => 'required|string|min:1|max:50',
        ];
    }
    public function messages(){
        return [
            'title.required' => "Birlik nommini kiriting",
            'title.string' => "Birlikni matn ko'rinishda kiriting",
            'title.min' => "Birlik kamida 1 ta belgidan iborat bo'lishi kerak",
            'title.max' => "Birlik 50 ta belgidan oshmasligi kerak"
        ];
    }
}
