<?php
namespace App\Interfaces;

interface UnityInterface{
    function index();
    function store($request);
    function update($id);
    function destroy($id);
}
