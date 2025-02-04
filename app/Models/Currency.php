<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        'from',
        'to',
        'value',
        'rate',
        'startDate',
        'endDate',
        'active',
        'user_id'
    ];
}
