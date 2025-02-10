<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceItemRequest extends FormRequest
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
            'invoice_id' => 'required|integer|exists:invoices,id',
            'quantity' => 'required|integer|min:1|max:100',
         ];
    }
    public function messages(){
        return [
            'product_id.required' => 'Mahsulot tanlanishi shart.',
            'product_id.integer' => 'Mahsulot ID butun son bo\'lishi kerak.',
            'product_id.exists' => 'Tanlangan mahsulot mahsulotlar jadvalidan  topilmadi.',

            'invoice_id.required' => 'Faktura tanlanishi shart.',
            'invoice_id.integer' => 'Faktura ID butun son bo\'lishi kerak.',
            'invoice_id.exists' => 'Tanlangan chiqim faktura fakturalar jadvalidan  topilmadi.',

            'quantity.required' => 'Miqdorni kiritish shart.',
            'quantity.integer' => 'Miqdor butun son bo\'lishi kerak.',
            'quantity.min' => 'Miqdor kamida 1 bo\'lishi kerak.',
            'quantity.max' => 'Miqdor 100 dan oshmasligi kerak.',
        ];
    }
}
