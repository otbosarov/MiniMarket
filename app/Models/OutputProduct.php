<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'unity_id',
        'amount',
        'currency_type',
        'currency_rate',
        'output_price',
        'user_id',
    ];
}
