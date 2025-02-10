<?php
namespace App\Interfaces;

interface CurrencyInterface{
    function todayExchangeRate();
    function exchangeRateStore($request);
    function exchangeRateUpdate($request, $id);
    function index();
}
