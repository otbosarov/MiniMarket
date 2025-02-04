<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'unity_id',
        'raise',
        'currency_type',
        'currency_rate',
        'input_price',
        'selling_price',
        'residue',
        'user_id',
    ];
}
