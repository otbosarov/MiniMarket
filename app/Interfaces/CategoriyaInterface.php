<?php
 namespace App\Interfaces;
interface CategoriyaInterface{
    function index();
    function store($request);
    function update( $request, $id);
    function destroy($id);
    function changeActive($id);
}
