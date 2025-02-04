<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InputProductRequest extends FormRequest
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
            'unity_id' => 'required|integer|exists:unities,id',
            'amount' => 'required|integer|min:1|max:100',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'currency_type' => 'required|string|in:UZS,USD',
            'input_price' => 'required|numeric|min:0'
        ];
    }
    public function messages()
    {
        return [
            'product_id.required' => 'Mahsulot tanlanishi shart.',
            'product_id.integer' => 'Mahsulot ID butun son bo\'lishi kerak.',
            'product_id.exists' => 'Tanlangan mahsulot mahsulotlar jadvalidan  topilmadi.',

            'unity_id.required' => 'Birlik tanlanishi shart.',
            'unity_id.integer' => 'Birlik ID butun son bo\'lishi kerak.',
            'unity_id.exists' => 'Tanlangan birlik birliklar jadvalidan topilmadi.',

            'amount.required' => 'Miqdorni kiritish shart.',
            'amount.integer' => 'Miqdor butun son bo\'lishi kerak.',
            'amount.min' => 'Miqdor kamida 1 bo\'lishi kerak.',
            'amount.max' => 'Miqdor 100 dan oshmasligi kerak.',

            'supplier_id.required' => 'Ta\'minotchi tanlanishi shart.',
            'supplier_id.integer' => 'Ta\'minotchi ID butun son bo\'lishi kerak.',
            'supplier_id.exists' => 'Tanlangan ta\'minotchi taminotchilardan jadvalidan topilmadi.',

            'currency_type.required' => 'Valyuta turi tanlanishi shart.',
            'currency_type.string'  => 'Valyuta turi matn ko\'rinishida bo\'lishi kerak.',
            'currency_type.in' => 'Valyuta turi faqat UZS yoki USD bo\'lishi mumkin.',

            'input_price.required' => 'Kirim narxi kiritish shart.',
            'input_price.numeric' => 'Kirim narxi raqam bo\'lishi kerak.',
            'input_price.min' => 'Kirim narxi 0 dan kichik bo\'lishi mumkin emas.',
        ];
    }
}
