<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Redeeming_Transaction;
use App\Models\EarnedPoint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminte\Support\Facades\Auth;


class RedeemManagementServices{
    public static function CreateTransaction($member_id, $points_redeemed, $transaction_datetime, $created_by){
        $sum_earnedpoints = EarnedPoint::where('member_id', $member_id)->sum('points_earn');
        $sum_redeemedpoints = Redeeming_Transaction::where('member_id', $member_id)->sum('points_redeemed');
        $points = $sum_earnedpoints - $sum_redeemedpoints;

        if(Redeeming_Transaction::where('member_id', $member_id)->where('points_redeemed', $points_redeemed)->where('transaction_datetime', $transaction_datetime)->exists()){
            $exist = Redeeming_Transaction::select('member_id', 'points_redeemed', 'transaction_datetime')->where('member_id', $member_id)->where('points_redeemed', $points_redeemed)->where('transaction_datetime', $transaction_datetime)->first();
            return response(['error' => ['message' =>'Redeemed Transaction already Exists!!', 'Redeemed_Transaction_Exists' => [$exist] ]], 200);
        }
        else {
            
            if($points <= $points_redeemed){
                
                return response(['error'=> ['message' => 'Unable to redeem, Not Enough Points!!', '*current_points'=>$points]], 200);
            }
            else{
                $redeempoints = Redeeming_Transaction::create([
                    'member_id' => $member_id,
                    'points_redeemed' => $points_redeemed,
                    'transaction_datetime' => $transaction_datetime,
                    'created_by' => $created_by
                ]);
               // return $redeempoints;
                return response(['message' => "Successfully Imported", 'Imported_Redeemed_Points' => [$redeempoints]], 200);

            }
            
        }
        

    }

    public static function Check_Reedemed_Points($all){
        $error = array();
        $error2 = array();
        $data = array();
        $message = collect();

      
        foreach($all as $allpoints){
            $member_id = $allpoints['member_id'];
            $points_redeemed = $allpoints['points_redeemed'];
            $transaction_datetime = $allpoints['transaction_datetime'];

            $sum_earnedpoints = EarnedPoint::where('member_id', $member_id)->sum('points_earn');
            $sum_redeemedpoints = Redeeming_Transaction::where('member_id', $member_id)->sum('points_redeemed');
            $points = $sum_earnedpoints - $sum_redeemedpoints;
           

            if(Redeeming_Transaction::where('member_id', $member_id)->where('points_redeemed', $points_redeemed)->where('transaction_datetime', $transaction_datetime)->exists()){
                $exist = Redeeming_Transaction::select('member_id', 'points_redeemed', 'transaction_datetime')->where('member_id', $member_id)->where('points_redeemed', $points_redeemed)->where('transaction_datetime', $transaction_datetime)->first();
                $res = 'Redeemed Transaction already Exists!!';
                array_push($error, $exist);
            }

            if($points <= $points_redeemed){
                $not_enough_points = EarnedPoint::select('member_id')->where('member_id', $member_id)->first();
                $res2 = 'Not Enough Points!!';
                array_push($error2, $not_enough_points);
            }
           
         
        }
        
        return response(['error' => ['message' => "Unable to Redeem!!", 'Redeemed_Transaction_Exists' => $error, 'Not_Enough_Points'=> $error2]], 200);

    }

    public static function Import_Redeem_Transaction($all, $created_by){
        $error = array();
        $data = array();
        $error2 = array();
        $inserted_redeemedpoints = array();

        
       

        foreach($all as $allredeemed){
            $member_id = $allredeemed['member_id'];
            $points_redeemed = $allredeemed['points_redeemed'];
            $transaction_datetime = $allredeemed['transaction_datetime'];
            $check = Redeeming_Transaction::where('member_id', $member_id)->where('transaction_datetime', $transaction_datetime)->where('points_redeemed', $points_redeemed);
            $sum_earnedpoints = EarnedPoint::where('member_id', $member_id)->sum('points_earn');
            $sum_redeemedpoints = Redeeming_Transaction::where('member_id', $member_id)->sum('points_redeemed');
            $points = $sum_earnedpoints - $sum_redeemedpoints;

            if($check->exists()){               
                $exist = $check->select('member_id', 'points_redeemed', 'transaction_datetime')->first();
                array_push($error, $exist);
            }
            elseif($points <= $points_redeemed){
                $not_enough_points = EarnedPoint::select('member_id')->where('member_id', $member_id)->first();
                $res2 = 'Not Enough Points!!';
                array_push($error2, $not_enough_points);
            }
            else{

                $redeempoints = Redeeming_Transaction::create([
                    'member_id' => $member_id,
                    'transaction_datetime' => $transaction_datetime,
                    'points_redeemed' => $points_redeemed,
                    'created_by' => $created_by
                ]);
                array_push($inserted_redeemedpoints, $redeempoints);
                array_push($error);
            }          
        }
        if(!count($inserted_redeemedpoints) > 0){
            return response(['error' => ['message' => "Unable to Redeem!!", 'Redeemed_Transaction_Exists' => $error, 'Not_Enough_Points' => $error2]], 200);
        }
         else{
             return response(['message' => "Successfully Imported", 'Imported_Redeemed_Points' => $inserted_redeemedpoints], 200);
         }
    }

    public static function List_Redeeming_Transactions($redeemsperpage){
        $list = Redeeming_Transaction::select('redeeming_transactions.id', 'members.first_name', 'members.last_name', 'members.mobile_number', 'redeeming_transactions.points_redeemed', 'redeeming_transactions.transaction_datetime')
        ->leftJoin('members', function($join){
            $join->on('redeeming_transactions.member_id', 'members.id');
         })->orderBy('redeeming_transactions.created_at', 'DESC')->paginate($redeemsperpage);
         return $list;
    }
    

    
}