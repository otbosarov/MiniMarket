<?php

namespace App\Http\Controllers;

use App\Models\UploadExcel;
use Illuminate\Http\Request;

class UserUploadToExcelController extends Controller
{
    public function index()
    {
        return UploadExcel::where('user_id', auth()->id())
            ->get();
    }
}
