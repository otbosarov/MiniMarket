<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'unity_id',
        'amount',
        'supplier_id',
        'currency_type',
        'currency_rate',
        'input_price',
        'selling_price',
        'user_id',
        'active',
    ];
}
