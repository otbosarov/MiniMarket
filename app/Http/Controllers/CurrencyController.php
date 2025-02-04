<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{
    public function todayExchangeRate()
    {
        $client = new Client();
        $key = "USD";
        $now = date('Y-m-d');
        $url = "https://cbu.uz/uz/arkhiv-kursov-valyut/json/" . $key . "/" . $now . "/";
        $response = $client->get($url);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();

        if ($statusCode == 200) {
            $data = json_decode($body, true);
        }
        $currency =  $data[0]['Rate'] ?? 13000;
        return response()->json(['message' => now()->toDateTimeString() . " sanadagi valyuta kursi: " . $currency . " so'm."], 200);
    }
    public function exchangeRateStore(CurrencyRequest $request)
    {
        if(!($this->check('currency','add'))){
            return response()->json(['message'=>"Amaliyot uchun huquq yo'q"],403);
        }
        try {
            Currency::create([
                'rate' => $request->rate,
                'startDate' => now()->toDateTime(),
                'user_id' => auth()->id(),
            ]);
            return response()->json(['message' => "Amaliyot bajarildi"], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => "Ma'lumot kiritishda xatolik sodir bo'ldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 500);
        }
    }
    public function exchangeRateUpdate(CurrencyRequest $request, $id)
    {
        if(!($this->check('currency','edit'))){
            return response()->json(['message'=>"Amaliyot uchun huquq yo'q"],403);
        }
        $currency = Currency::where('id', $id)
            ->where('endDate', null)
            ->where('active', true)
            ->orderBy('id', 'desc')
            ->first();
        if (!$currency) {
            return response()->json(['message' => "Bunday ma'lumot topilmadi"], 404);
        }
        DB::beginTransaction();
        try {
            $currency->update([
                'endDate' => now()->toDateTime(),
                'active' => false
            ]);
            Currency::create([
                'rate' => $request->rate,
                'startDate' => now()->toDateTime(),
                'user_id' => auth()->id(),
            ]);
            DB::commit();
            return response()->json(['messgae' => "Valyuta kursi yangilandi"], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => "Kurs yangilashda xatolik berdi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 500);
        }
    }
    public function index()
    {
        return Currency::where('endDate', null)
            ->where('active', true)
            ->orderBy('id', 'desc')
            ->get();
    }
}
