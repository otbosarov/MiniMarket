<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnityRequest;
use App\Interfaces\UnityInterface;
use App\Models\Unity;
use Illuminate\Http\Request;

class UnityController extends Controller
{
    public function __construct(protected UnityInterface $unityInterfaceRepo) {}
    public function index()
    {
        return $this->unityInterfaceRepo->index();
    }
    public function store(UnityRequest $request)
    {
        if (!($this->check('unity', 'add'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
        return $this->unityInterfaceRepo->store($request);
    }
    public function update($id)
    {
        if (!($this->check('unity', 'edit'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
        return $this->unityInterfaceRepo->update($id);
    }
    public function destroy($id)
    {
        if (!($this->check('unity', 'delete'))) {
            return response()->json(['message' => "Amaliyot uchun huquq yo'q"], 403);
        }
       return $this->unityInterfaceRepo->destroy($id);
    }
}
