<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Services\PointManagementServices;
use App\Http\Requests\EarnedPointRequest;
use App\Http\Requests\EarnedPointRequestV2;
use App\Http\Requests\ClearedPointRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 



class PointManagementController extends Controller
{
    public function ListMemberPoints(Request $request){
        $member_id = $request->member_id;
        $listmemberpoints = PointManagementServices::List_Member_Points($member_id);
        return $listmemberpoints;
    }

    public function  SumPointsbyMember(Request $request){
        $member_id = $request->member_id;
        $sumpointsbymember = PointManagementServices::Sum_Points_by_Member($member_id);
        return $sumpointsbymember;

    }

    public function ListPointsTransaction(Request $request){
        $pointsperpage = $request->pointsperpage;
        $transaction = PointManagementServices::List_Points_Transaction($pointsperpage);
        return $transaction;
    }

    public function Create(Request $request){
        $member_id = $request->member_id;
        $transaction_no = $request->transaction_no;
        $amount = $request->amount;
        $points_earn = $request->points_earn;
        $transaction_datetime = $request->transaction_datetime;
        $created_by = auth('sanctum')->user()->id;
        $create = PointManagementServices::CreateTransactions($member_id, $transaction_no, $amount, $points_earn, $transaction_datetime, $created_by);
        return $create;
    }

    public function ImportEarnedPoints(EarnedPointRequest $request){
        $all = $request->all();
        $created_by = auth('sanctum')->user()->id;
        $import = PointManagementServices::Import_Earned_Points($all, $created_by);
        return $import; 
    }

    public function CheckEarnedPoints(EarnedPointRequest $request){
        $data = [ 'data' => $request->all() ];
        $all = $request->all();
        $check = PointManagementServices::Check_Earned_Points($all);
        return $check;
    }

    public function SearchEarnedPoints(Request $request){
        $searchvalue = $request->searchvalue;
        $pointsperpage = $request->pointsperpage;
        $search_details = PointManagementServices::Search_Earned_Points($searchvalue, $pointsperpage);
        return $search_details;
    }

    public function ClearPoints(ClearedPointRequest $request){
    
        $all = $request->data;
        $cleared = PointManagementServices::Clear_Points($all);
        return $cleared;
    }

    public function ListClearedPoints(Request $request){
        $clearedpointsperpage = $request->clearedpointsperpage;
        $clearedpoints = PointManagementServices::List_Cleared_Points($clearedpointsperpage);
        return $clearedpoints;

    }

    public function SearchClearedPoints(Request $request){
        $clearedpointsperpage = $request->clearedpointsperpage;
        $searchvalue = $request->searchvalue;
        $searchclearedpoints = PointManagementServices::Search_Cleared_Points($searchvalue, $clearedpointsperpage);
        return $searchclearedpoints;
    }

    public function TestImportEarnedPoints(EarnedPointRequestV2 $request){
         $all = $request->data;
         $created_by = auth('sanctum')->user()->id;
        $import = PointManagementServices::Test_Import_Earned_Points($all, $created_by);
       return $import; 
    }

   public function  TestCheckEarnedPoints(Request $request){
    $all = $request->data;
    $check = PointManagementServices::Test_Check_Earned_Points($all);
    return $check;
}
}
