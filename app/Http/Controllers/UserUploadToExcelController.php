<?php

namespace App\Http\Controllers;

use App\Http\Resources\UploadExcelResource;
use App\Models\UploadExcel;
use Illuminate\Http\Request;

class UserUploadToExcelController extends Controller
{
    public function index()
    {
        $search = request('search');
        $excel = UploadExcel::where('user_id', auth()->id())
            ->when($search, function ($query) use ($search) {
                $query->where('upload_excels.file_name', 'ILIKE', "%$search%");
            })
            ->orderBy('id', 'desc')
            ->paginate(15);
        return UploadExcelResource::collection($excel);
    }
}
