<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminte\Support\Facades\Auth;
use App\Services\RedeemManagementServices;


class RedeemManagementController extends Controller
{
    public function Create(Request $request){
        $member_id = $request->member_id;
        $points_redeemed = $request->points_redeemed;
        $transaction_datetime = $request->transaction_datetime;
        $created_by = auth('sanctum')->user()->id;
        $create = RedeemManagementServices::CreateTransaction($member_id, $points_redeemed, $transaction_datetime, $created_by);
        return $create;

    }

    public function Check(Request $request){
        $all = $request->all();
        $check = RedeemManagementServices::Check_Reedemed_Points($all);
        return $check;
    }

    public function Import(Request $request){
        $all = $request->all();
        $created_by = auth('sanctum')->user()->id;
        $import = RedeemManagementServices::Import_Redeem_Transaction($all, $created_by);
        return $import;
    }

    public function List(Request $request){
        $redeemsperpage = $request['redeemsperpage'];
        $redeemlist = RedeemManagementServices::List_Redeeming_Transactions($redeemsperpage);
        return $redeemlist;
    }
}
