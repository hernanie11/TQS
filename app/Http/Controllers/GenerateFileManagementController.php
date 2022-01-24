<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminte\Support\Facades\Auth;
use App\Services\GenerateFileManagementServices;
use App\Http\Requests\GenerateFileRequest;

class GenerateFileManagementController extends Controller
{
    public function Gen(GenerateFileRequest $request){
        $user = $request->user_account;
        $member = $request->member;
        $store = $request->store;
        $generate = GenerateFileManagementServices::GenerateFile($user, $member, $store);
       return $generate;
    }
}
