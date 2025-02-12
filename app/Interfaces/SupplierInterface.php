<?php
namespace App\Interfaces;
interface SupplierInterface{
    function index();
    function store($request);
    function update($request, $id);
    function destroy($id);
    function changeAtive($id);
}
