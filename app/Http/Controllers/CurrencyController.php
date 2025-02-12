<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyRequest;
use App\Interfaces\CurrencyInterface;
use App\Models\Currency;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{
    public function __construct(protected CurrencyInterface $currencyInterfaceRepo) {}
    public function todayExchangeRate()
    {
        return $this->currencyInterfaceRepo->todayExchangeRate();
    }
    public function exchangeRateStore(CurrencyRequest $request)
    {
        // if (!($this->check('currency', 'add'))) {
        //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        // }
        return $this->currencyInterfaceRepo->exchangeRateStore($request);
    }
    public function exchangeRateUpdate(CurrencyRequest $request, $id)
    {
       // if (!($this->check('currency', 'edit'))) {
       //     return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
       // }
        return $this->currencyInterfaceRepo->exchangeRateUpdate($request, $id);
    }
    public function index()
    {
        return $this->currencyInterfaceRepo->index();
    }
}
