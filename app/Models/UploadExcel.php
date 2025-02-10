<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadExcel extends Model
{
    use HasFactory;
    const STATUS_PROCESSING = "processing";
    const STATUS_COMPLETED = "completed ";
    const STATUS_FAILED = "failed";
    protected $fillable = [
        'user_id',
        'status',
        'file_name',
        'url',
        'active',
    ];
}
