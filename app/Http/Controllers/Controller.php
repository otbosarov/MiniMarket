<?php

namespace App\Http\Controllers;

use App\Models\UserRule;
use App\Models\UserRules;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function  check($modul, $action){
        return UserRule::join('rules', 'rules.id', 'user_rules.rule_id')
        ->join('modules', 'modules.id', 'rules.modul_id')
        ->join('actions', 'actions.id', 'rules.action_id')
        ->where('actions.name', $action)
        ->where('modules.title', $modul)
        ->where('user_rules.user_id', auth()->id())
        ->where('user_rules.active', true)
        ->where('rules.active', true)
        ->first();
    }
}
