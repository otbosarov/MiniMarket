<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutputProductRequest extends FormRequest
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
            'product_id' => 'required|integer|exists:products,id',
            'amount' => 'required|integer|min:1|max:100',
            'currency_type' => 'required|string|in:UZS,USD',
        ];
    }
    public function messages()
    {
        return [
            'product_id.required' => 'Mahsulot tanlanishi shart.',
            'product_id.integer' => 'Mahsulot ID butun son bo\'lishi kerak.',
            'product_id.exists' => 'Tanlangan mahsulot mahsulotlar jadvalidan  topilmadi.',

            'amount.required' => 'Miqdorni kiritish shart.',
            'amount.integer' => 'Miqdor butun son bo\'lishi kerak.',
            'amount.min' => 'Miqdor kamida 1 bo\'lishi kerak.',
            'amount.max' => 'Miqdor 100 dan oshmasligi kerak.',

            'currency_type.required' => 'Valyuta turi tanlanishi shart.',
            'currency_type.string'  => 'Valyuta turi matn ko\'rinishida bo\'lishi kerak.',
            'currency_type.in' => 'Valyuta turi faqat UZS yoki USD bo\'lishi mumkin.',
        ];
    }
}
