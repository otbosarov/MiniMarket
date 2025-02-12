<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\MonthDaysService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use MonthDaysService;
    public function index(){
        return $this->getMonthDays(6);
        return Invoice::orderBy('id','desc')
        ->get();
    }
    public function store(Request $request){
       Invoice::create([
        'user_id' => auth()->id()
       ]);
       return  response()->json(['message' => "Chiqim faktura yaratildi"],201);
    }
}
