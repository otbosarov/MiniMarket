<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
            'rate' => "required|numeric|between:10000,15000"
        ];
    }
    public function messages()
    {
        return [
            'rate.required' => 'Kurs maydoni to\'ldirilishi shart.',
            'rate.numeric' => 'Kurs raqam bo\'lishi kerak.',
            'rate.between' => 'Kurs qiymati 10 000 dan 15 000 gacha bo\'lishi kerak.',
        ];
    }
}
