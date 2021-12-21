<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Services\PointManagementServices;

class PointManagementController extends Controller
{
    public function ListMemberPoints(Request $request){
        $member_id = $request->member_id;
        $listmemberpoints = PointManagementServices::List_Member_Points($member_id);
        return $listmemberpoints;
    }

    public function  SumPointsbyMember(Request $request){

    }

    public function ListPointsTransaction(Request $request){

    }
}
