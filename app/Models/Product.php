<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'category_id',
        'user_id',
        'active',
    ];

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
