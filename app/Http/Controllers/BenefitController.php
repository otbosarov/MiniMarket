<?php

namespace App\Http\Controllers;

use App\Http\Resources\UniversalResource;
use App\Interfaces\BenefitInterface;
use App\Models\Benefit;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    public function __construct(protected BenefitInterface $benefitInterfaceRepo) {}
    public function index()
    {
        // if (!($this->check('benefit', 'show'))) {
        //     return response()->json(['message' => "Amaliyotga huquq yo'q"], 403);
        // }
       return $this->benefitInterfaceRepo->index();
    }
}
