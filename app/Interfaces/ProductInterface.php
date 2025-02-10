<?php
namespace App\Interfaces;

interface ProductInterface{
    function index();
    function store($request);
    function update($request, $id);
    function destroy($id);
    function changeActive($id);
}
