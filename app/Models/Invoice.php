<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable  = [
        'user_id',
        'currency_type',
        'total_price',
        'active',
    ];
    public function invoice_products(){
        return $this->hasMany(InvoiceProducts::class,'invoice_id','id');
    }
    public function invoice_user(){
        return $this->hasOne(User::class,'id','user_id');
    }

}
