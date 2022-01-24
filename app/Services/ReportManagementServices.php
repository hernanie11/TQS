<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Redeeming_Transaction;
use App\Models\EarnedPoint;
use App\Models\ClearedPoint;
use Illuminate\Http\Request;
use Illuminte\Support\Facades\Auth;

class ReportManagementServices{

    public static function Report($selectedReport, $dateRangedBased, $dateRanged, $category, $status){

        foreach($dateRanged as $date) {
            $start_date = $date['start'];
            $end_date = $date['end'];    
        }
        if($selectedReport == 'Earned-Points'){
            if(($dateRangedBased == "Date Synched / Upload")){
                if(empty($category) and empty($status)){
                    $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                    ->leftJoin('members', function($join){
                        $join->on('earnedpoints.member_id', 'members.id');
                    })->whereBetween('earnedpoints.created_at', [$start_date, $end_date])->get();
                    return $report;

                }


                if(!empty($category) and empty($status)){ 
                    if(!empty($category[1])){

                        if(((($category[0] == "Synched") and ($category[1] == "Uploaded")) || (($category[0] == "Uploaded") and ($category[1] == "Synched")))){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })->whereBetween('earnedpoints.created_at', [$start_date, $end_date])->get();
                          return $report;
                        }
                    }
                    else{
                        if(($category[0]== "Synched") ){
                        $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                        ->leftJoin('members', function($join){
                            $join->on('earnedpoints.member_id', 'members.id');
                        })->whereBetween('earnedpoints.created_at', [$start_date, $end_date])
                        ->where('earnedpoints.category', 'synched')->get();
                           return $report;
                        }

                        if(($category[0]== "Uploaded")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })->whereBetween('earnedpoints.created_at', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'uploaded')->get();
                            return $report;
                        }
                    }    
                }
                if(empty($category) and !empty($status)){
                    if(!empty($status[1])){
                        if(((($status[0] == "Not Cleared") and ($status[1] == "Cleared")) || (($status[0] == "Cleared") and ($status[1] == "Not Cleared")))){
                            echo "test";
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.created_at', [$start_date, $end_date])->get();
                          return $report;
                        }
                    }
                    else{
                        if(($status[0]== "Cleared") ){
                        $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                        ->leftJoin('members', function($join){
                            $join->on('earnedpoints.member_id', 'members.id');
                        })
                        ->whereBetween('earnedpoints.created_at', [$start_date, $end_date])
                        ->where('earnedpoints.is_cleared', true)->get();
                           return $report;
                        }

                        if(($status[0]== "Not Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.created_at', [$start_date, $end_date])
                            ->where('earnedpoints.is_cleared', false)->get();
                            return $report;
                        }
                    }    
                }

                if(!empty($category) and !empty($status)){ 
                    if(empty($category[1]) and empty($status[1])){
                        if(($category[0] == "Synched" ) and ($status[0] == "Not Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.created_at', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'synched')->where('earnedpoints.is_cleared', false)->get();
                           return $report;
                        }

                        if(($category[0] == "Synched" ) and ($status[0] == "Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.created_at', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'synched')->where('earnedpoints.is_cleared', true)->get();
                           return $report;
                        }

                        if(($category[0] == "Uploaded" ) and ($status[0] == "Not Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.created_at', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'uploaded')->where('earnedpoints.is_cleared', false)->get();
                           return $report;
                        }

                        if(($category[0] == "Uploaded" ) and ($status[0] == "Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.created_at', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'uploaded')->where('earnedpoints.is_cleared', true)->get();
                           return $report;
                        }

                    }

                    if(!empty($category[1]) and empty($status[1])){
                        if($status[0] == 'Cleared'){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.created_at', [$start_date, $end_date])
                            ->where('earnedpoints.is_cleared', true)->get();
                           return $report;
                        }
                        if($status[0] == 'Not Cleared'){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.created_at', [$start_date, $end_date])
                            ->where('earnedpoints.is_cleared', false)->get();
                           return $report;
                        }    
                    }

                    if(empty($category[1]) and !empty($status[1])){
                        if($category[0] == 'Synched'){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.created_at', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'synched')->get();
                           return $report;
                        }
                        if($category[0] == 'Uploaded'){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.created_at', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'uploaded')->get();
                           return $report;
                        }


                    }
                   
                }


            }

            if(($dateRangedBased == "Date Earned")){

                if(empty($category) and empty($status)){
                    $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                    ->leftJoin('members', function($join){
                        $join->on('earnedpoints.member_id', 'members.id');
                    })
                    ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])->get();
                    return $report;
                }


                if(!empty($category) and empty($status)){ 
                    if(!empty($category[1])){

                        if(((($category[0] == "Synched") and ($category[1] == "Uploaded")) || (($category[0] == "Uploaded") and ($category[1] == "Synched")))){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])->get();
                          return $report;
                        }
                    }
                    else{
                        if(($category[0]== "Synched") ){
                        $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                        ->leftJoin('members', function($join){
                            $join->on('earnedpoints.member_id', 'members.id');
                        })
                        ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])
                        ->where('earnedpoints.category', 'synched')->get();
                           return $report;
                        }

                        if(($category[0]== "Uploaded")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'uploaded')->get();
                            return $report;
                        }
                    }    
                }
                if(empty($category) and !empty($status)){
                    if(!empty($status[1])){
                        if(((($status[0] == "Not Cleared") and ($status[1] == "Cleared")) || (($status[0] == "Cleared") and ($status[1] == "Not Cleared")))){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])->get();
                          return $report;
                        }
                    }
                    else{
                        if(($status[0]== "Cleared") ){
                        $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                        ->leftJoin('members', function($join){
                            $join->on('earnedpoints.member_id', 'members.id');
                        })
                        ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])
                        ->where('earnedpoints.is_cleared', true)->get();
                           return $report;
                        }

                        if(($status[0]== "Not Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.is_cleared', false)->get();
                            return $report;
                        }
                    }    
                }

                if(!empty($category) and !empty($status)){ 
                    if(empty($category[1]) and empty($status[1])){
                        if(($category[0] == "Synched" ) and ($status[0] == "Not Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'synched')->where('earnedpoints.is_cleared', false)->get();
                           return $report;
                        }

                        if(($category[0] == "Synched" ) and ($status[0] == "Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'synched')->where('earnedpoints.is_cleared', true)->get();
                           return $report;
                        }

                        if(($category[0] == "Uploaded" ) and ($status[0] == "Not Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'uploaded')->where('earnedpoints.is_cleared', false)->get();
                           return $report;
                        }

                        if(($category[0] == "Uploaded" ) and ($status[0] == "Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'uploaded')->where('earnedpoints.is_cleared', true)->get();
                           return $report;
                        }

                    }

                    if(!empty($category[1]) and empty($status[1])){
                        if($status[0] == 'Cleared'){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.is_cleared', true)->get();
                           return $report;
                        }
                        if($status[0] == 'Not Cleared'){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.is_cleared', false)->get();
                           return $report;
                        }    
                    }

                    if(empty($category[1]) and !empty($status[1])){
                        if($category[0] == 'Synched'){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'synched')->get();
                           return $report;
                        }
                        if($category[0] == 'Uploaded'){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.transaction_datetime', [$start_date, $end_date])
                            ->where('category', 'uploaded')->get();
                           return $report;
                        }


                    }
                   
                }


            }

            if(($dateRangedBased == "Date Cleared Points")){
                if(empty($category) and empty($status)){
                    $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                    ->leftJoin('members', function($join){
                        $join->on('earnedpoints.member_id', 'members.id');
                    })
                    ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])->get();
                    return $report;
                }


                if(!empty($category) and empty($status)){ 
                    if(!empty($category[1])){

                        if(((($category[0] == "Synched") and ($category[1] == "Uploaded")) || (($category[0] == "Uploaded") and ($category[1] == "Synched")))){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])->get();
                          return $report;
                        }
                    }
                    else{
                        if(($category[0]== "Synched") ){
                        $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                        ->leftJoin('members', function($join){
                            $join->on('earnedpoints.member_id', 'members.id');
                        })
                        ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])
                        ->where('earnedpoints.category', 'synched')->get();
                           return $report;
                        }

                        if(($category[0]== "Uploaded")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'uploaded')->get();
                            return $report;
                        }
                    }    
                }
                if(empty($category) and !empty($status)){
                    if(!empty($status[1])){
                        if(((($status[0] == "Not Cleared") and ($status[1] == "Cleared")) || (($status[0] == "Cleared") and ($status[1] == "Not Cleared")))){
                            echo "test";
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])->get();
                          return $report;
                        }
                    }
                    else{
                        if(($status[0]== "Cleared") ){
                        $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                        ->leftJoin('members', function($join){
                            $join->on('earnedpoints.member_id', 'members.id');
                        })
                        ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])
                        ->where('earnedpoints.is_cleared', true)->get();
                           return $report;
                        }

                        if(($status[0]== "Not Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.is_cleared', false)->get();
                            return $report;
                        }
                    }    
                }

                if(!empty($category) and !empty($status)){ 
                    if(empty($category[1]) and empty($status[1])){
                        if(($category[0] == "Synched" ) and ($status[0] == "Not Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'synched')->where('earnedpoints.is_cleared', false)->get();
                           return $report;
                        }

                        if(($category[0] == "Synched" ) and ($status[0] == "Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'synched')->where('earnedpoints.is_cleared', true)->get();
                           return $report;
                        }

                        if(($category[0] == "Uploaded" ) and ($status[0] == "Not Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'uploaded')->where('earnedpoints.is_cleared', false)->get();
                           return $report;
                        }

                        if(($category[0] == "Uploaded" ) and ($status[0] == "Cleared")){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'uploaded')->where('earnedpoints.is_cleared', true)->get();
                           return $report;
                        }

                    }

                    if(!empty($category[1]) and empty($status[1])){
                        if($status[0] == 'Cleared'){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.is_cleared', true)->get();
                           return $report;
                        }
                        if($status[0] == 'Not Cleared'){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.is_cleared', false)->get();
                           return $report;
                        }    
                    }

                    if(empty($category[1]) and !empty($status[1])){
                        if($category[0] == 'Synched'){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'synched')->get();
                           return $report;
                        }
                        if($category[0] == 'Uploaded'){
                            $report = EarnedPoint::select('earnedpoints.id', 'earnedpoints.transaction_no', 'earnedpoints.category', 'members.first_name', 'members.last_name', 'members.mobile_number', 'earnedpoints.amount', 'earnedpoints.points_earn', DB::raw('if(earnedpoints.is_cleared = 1, "Cleared", "Not Cleared") as status'), 'earnedpoints.created_at', 'earnedpoints.transaction_datetime', 'earnedpoints.cleared_datetime')
                            ->leftJoin('members', function($join){
                                $join->on('earnedpoints.member_id', 'members.id');
                            })
                            ->whereBetween('earnedpoints.cleared_datetime', [$start_date, $end_date])
                            ->where('earnedpoints.category', 'uploaded')->get();
                           return $report;
                        }


                    }
                   
                }


            }

            // if(($dateRangedBased == NULL)){
            //     return response(['message'=> 'The given data was invalid.', 'error'=>['dateRangedBased'=>['The selected report field is required.']
            // ]], 200);
            // }



             
        }

        if($selectedReport == 'Redeemed-Points'){
            if(($dateRangedBased == "Date Synched")){
                $report = Redeeming_Transaction::select('redeeming_transactions.id', 'members.first_name', 'members.last_name', 'redeeming_transactions.store_name', 'redeeming_transactions.points_redeemed', 'redeeming_transactions.transaction_datetime', 'redeeming_transactions.created_at')
                ->leftJoin('members', function($join){
                    $join->on('redeeming_transactions.member_id', 'members.id');
                })
               ->whereBetween('redeeming_transactions.created_at', [$start_date, $end_date])->get();
                return $report;
            }

            if(($dateRangedBased == "Date Redeemed")){
                $report = Redeeming_Transaction::select('redeeming_transactions.id', 'members.first_name', 'members.last_name', 'redeeming_transactions.store_name', 'redeeming_transactions.points_redeemed', 'redeeming_transactions.transaction_datetime', 'redeeming_transactions.created_at')
                ->leftJoin('members', function($join){
                    $join->on('redeeming_transactions.member_id', 'members.id');
                })
                ->whereBetween('redeeming_transactions.transaction_datetime', [$start_date, $end_date])->get();
                return $report;
            }

            if(($dateRangedBased == NULL)){
                return [];
            }
            
        }

        if($selectedReport == 'Cleared-Points'){
            $report = ClearedPoint::select('clearedpoints.id','members.first_name', 'members.last_name', 'clearedpoints.total_cleared_points')
            ->leftJoin('members', function($join){
                $join->on('clearedpoints.member_id', 'members.id');
            })->whereBetween('clearedpoints.created_at', [$start_date, $end_date])->get();
            return $report; 
        }

        

     
        
        
         




    }

}