<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadExcel extends Model
{
    use HasFactory;
    const STATUS_PROCESSING = "Jarayonda";
    const STATUS_COMPLETED = "Yuklab olindiu";
    const STATUS_FAILED = "Excel yuklashda xatolik";
    protected $fillable = [
        'user_id',
        'status',
        'url',
        'active',
    ];
}
