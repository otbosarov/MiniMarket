<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProducts extends Model
{
    use HasFactory;
    const STATUS_ON_SALE = "on_sale";
    const STATUS_SOLD = "sold";
    const STATUS_RETURNED = "returned";
    protected $fillable = [
        'invoice_id',
        'product_id',
        'unity',
        'amount',
        'currency_type',
        'selling_price',
        'status',
    ];
}
