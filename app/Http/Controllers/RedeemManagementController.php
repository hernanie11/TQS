<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminte\Support\Facades\Auth;
use App\Services\RedeemManagementServices;
use App\Http\Requests\RedeemPointRequest;


class RedeemManagementController extends Controller
{
    public function Create(RedeemPointRequest $request){
        $member_id = $request->member_id;
        $points_redeemed = $request->points_redeemed;
        $transaction_datetime = $request->transaction_datetime;
        $store_code = $request->store_code;
        $store_name = $request->store_name;
        $created_by = auth('sanctum')->user()->id;
        $create = RedeemManagementServices::CreateTransaction($member_id, $points_redeemed, $transaction_datetime, $store_code, $store_name, $created_by);
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

    public function Search(Request $request){
        $redeemsperpage = $request['redeemsperpage'];
        $searchvalue = $request['searchvalue'];
        $redeemsearch = RedeemManagementServices::Search_Redeeming_Transactions($searchvalue, $redeemsperpage);
        return $redeemsearch;
    }


}
