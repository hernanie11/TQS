<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\EarnedPoint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminte\Support\Facades\Auth;


class PointManagementServices{
    public static function List_Member_Points($member_id){
         $list = EarnedPoint::select('earnedpoints.member_id', 'earnedpoints.points_earn', 'earnedpoints.transaction_datetime', 'members.first_name', 'members.last_name', 'members.mobile_number')
         ->leftJoin('members', function($join){
             $join->on('earnedpoints.member_id', 'members.id');
         })->where('earnedpoints.member_id', $member_id)->orderBy('earnedpoints.transaction_datetime', 'DESC')->paginate(5);;
         return $list;
    } 

    public static function Sum_Points_by_Member($member_id){
        $sum = EarnedPoint::select(DB::raw('SUM(`points_earn`) as Total_Points'))->where('member_id', $member_id)->first();
        return $sum;
    }

    public static function List_Points_Transaction($pointsperpage){
        $list = EarnedPoint::select('earnedpoints.id','members.first_name', 'members.last_name', 'members.mobile_number','earnedpoints.transaction_no', 'earnedpoints.amount', 'earnedpoints.points_earn', 'earnedpoints.transaction_datetime')
         ->leftJoin('members', function($join){
             $join->on('earnedpoints.member_id', 'members.id');
         })->orderBy('earnedpoints.transaction_datetime', 'DESC')->paginate($pointsperpage);;
         return $list;
    } 

    public static function CreateTransactions($member_id, $transaction_no, $amount, $points_earn, $transaction_datetime, $created_by){
        if(EarnedPoint::where('member_id', $member_id)->where('transaction_datetime', $transaction_datetime)->exists()){
            echo "already Exist";
        }
        else {
            $earnpoints = EarnedPoint::create([
                'member_id' => $member_id,
                'transaction_no' => $transaction_no,
                'amount' => $amount,
                'points_earn' => $points_earn,
                'transaction_datetime' => $transaction_datetime,
                'created_by' => $created_by
            ]);
            return $earnpoints;
        }

    }

    public static function Import_Earned_Points($all, $created_by){
        $error = array();
        $data = array();
       $inserted_earnedpoints = array();

       foreach($all as $allpoints){
        $member_id = $allpoints['member_id'];
        $transaction_no = $allpoints['transaction_no'];
        $amount = $allpoints['amount'];
        $points_earn = $allpoints['points_earn'];
        $transaction_datetime = $allpoints['transaction_datetime'];

        if(EarnedPoint::where('member_id', $member_id)->where('transaction_datetime', $transaction_datetime)->where('transaction_no', $transaction_no)->exists()){
            $exist = EarnedPoint::select('member_id', 'transaction_datetime')->where('member_id', $member_id)
            ->where('transaction_datetime', $transaction_datetime)->first();

            array_push($error, $exist);
        }
        else{
            $earnpoints = EarnedPoint::create([
                'member_id' => $member_id,
                'transaction_no' => $transaction_no,
                'amount' => $amount,
                'points_earn' => $points_earn,
                'transaction_datetime' => $transaction_datetime,
                'created_by' => $created_by
            ]);

            array_push($inserted_earnedpoints, $member_id);
            array_push($error);
        }

       }
       $message = "No EarnedPoints are Imported";
       if(count($inserted_earnedpoints) > 0){
        $message = "EarnedPoints are Succesfully Imported";
       }

       return response(
        [
        'EarnedPointExists' => $error, 
        'message'=>$message, 
        'imported_earned_points' => $inserted_earnedpoints
    ], 200
    );

    }

    public static function Check_Earned_Points($all){
        $error = array();
        $data = array();

        foreach($all as $allpoints){
            $member_id = $allpoints['member_id'];
            $transaction_no = $allpoints['transaction_no'];
            $amount = $allpoints['amount'];
            $points_earn = $allpoints['points_earn'];
            $transaction_datetime = $allpoints['transaction_datetime'];

            if(EarnedPoint::where('member_id', $member_id)->where('transaction_datetime', $transaction_datetime)->where('transaction_no', $transaction_no)->exists()){
                $exist = EarnedPoint::select('member_id', 'transaction_datetime')->where('member_id', $member_id)
                ->where('transaction_datetime', $transaction_datetime)->first();
                 array_push($error, $exist);
             }
       }
       return response(['EarnedPointsExists' => $error]);
     }

     public static function Search_Earned_Points($searchvalue, $pointsperpage){
        $search = EarnedPoint::select('earnedpoints.id','members.first_name', 'members.last_name', 'members.mobile_number','earnedpoints.transaction_no', 'earnedpoints.amount', 'earnedpoints.points_earn', 'earnedpoints.transaction_datetime')
        ->leftJoin('members', function($join){
            $join->on('earnedpoints.member_id', 'members.id');
        })
        ->where('members.first_name', 'LIKE', "%{$searchvalue}%")
        ->orWhere('members.last_name', 'LIKE', "%{$searchvalue}%")
        ->orWhere('members.mobile_number', 'LIKE', "%{$searchvalue}%")
        ->orWhere('earnedpoints.transaction_no', 'LIKE', "%{$searchvalue}%")
        ->orWhere('earnedpoints.transaction_datetime', 'LIKE', "%{$searchvalue}%")
        ->orderBy('earnedpoints.transaction_datetime', 'DESC')->paginate($pointsperpage);;
        return $search;

     }
    

    
}
 