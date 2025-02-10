<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(){
        return Invoice::get();
    }
    public function store(Request $request){
       Invoice::create([
        'user_id' => auth()->id()
       ]);
       return  response()->json(['message' => "Chiqim faktura yaratildi"],201);
    }
}
