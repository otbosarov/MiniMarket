<?php
namespace App\Interfaces;
interface ProductDetailInterface{
    function index();
    function update($request, $id);
}
