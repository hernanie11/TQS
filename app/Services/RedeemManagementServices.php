<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Redeeming_Transaction;
use App\Models\EarnedPoint;
use App\Models\ClearedPoint;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminte\Support\Facades\Auth;


class RedeemManagementServices{
    public static function CreateTransaction($member_id, $points_redeemed, $transaction_datetime, $store_code, $store_name, $created_by){
       // $sum_earnedpoints = ClearedPoint::where('member_id', $member_id)->sum('total_cleared_points');
       // $sum_redeemedpoints = Redeeming_Transaction::where('member_id', $member_id)->sum('points_redeemed');
       // $points = $sum_earnedpoints - $sum_redeemedpoints;
        $check = Redeeming_Transaction::where('member_id', $member_id)->where('points_redeemed', $points_redeemed)->where('transaction_datetime', $transaction_datetime);
        $total_cleared_points = ClearedPoint::select('total_cleared_points')->where('member_id', $member_id)->sum('total_cleared_points');
        if($check->exists()){
            $exist = $check->select('member_id', 'points_redeemed', 'transaction_datetime')->first();
           // return response(['message'=> 'Unable to redeem, Not enough points','error' => ['message' =>'Redeemed Transaction already Exists!!', 'Redeemed_Transaction_Exists' => [$exist] ]], 200);
           return response()->json(['message'=> 'The given data was invalid.', 'error'=> ['data'=>['The data has already been taken.']]], 422);

        }
        else {
            if($total_cleared_points <= $points_redeemed){
                
                return response()->json(['message'=> 'Unable to redeem, Not enough points', 'error'=> ['*current_points'=>$total_cleared_points]], 422);
            }
            else{
                $redeempoints = Redeeming_Transaction::create([
                    'member_id' => $member_id,
                    'points_redeemed' => $points_redeemed,
                    'transaction_datetime' => $transaction_datetime,
                    'store_code' => $store_code,
                    'store_name' => $store_name,
                    'created_by' => $created_by
                ]);
                //tees
                $clearedpoint = ClearedPoint::where('member_id', $member_id);
                $update_cleared_points = ClearedPoint::where('member_id', $member_id)->update([
                    'total_cleared_points' => DB::raw('total_cleared_points - ' .$points_redeemed)
                ]);
                ////
                return response(['code' => '201','message' => "Successfully Redeemed"], 201);
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
            $check = Redeeming_Transaction::where('member_id', $member_id)->where('points_redeemed', $points_redeemed)->where('transaction_datetime', $transaction_datetime);
            $total_cleared_points = ClearedPoint::select('total_cleared_points')->where('member_id', $member_id)->sum('total_cleared_points');

            if($check->exists() || $total_cleared_points < $points_redeemed){          
                if($check->exists()){
                    $exist = $check->select('member_id', 'points_redeemed', 'transaction_datetime')->first();
                    $res = 'Redeemed Transaction already Exists!!';
                    array_push($error, $exist);
                }
                if($total_cleared_points < $points_redeemed){
                    $not_enough_points = ClearedPoint::select('member_id')->where('member_id', $member_id)->first();
                    array_push($error2, $not_enough_points);
                }
            }
           
         
        }
        
        return response(['error' => ['message' => "Unable to Redeem!!", 'Redeemed_Transaction_Exists on' => $error, 'Not_Enough_Points on'=> $error2]], 200);

    }

    public static function Import_Redeem_Transaction($all, $created_by){
        $error_member_id = array();
        $error = array();
        $data = array();
        $error2 = array();
        $inserted_redeemedpoints = array();


        foreach($all as $allredeemed){
            $member_id = $allredeemed['member_id'];
            $points_redeemed = $allredeemed['points_redeemed'];
            $transaction_datetime = $allredeemed['transaction_datetime'];
            $store_code = $allredeemed['store_code'];
            $store_name = $allredeemed['store_name'];
            $check = Redeeming_Transaction::where('member_id', $member_id)->where('transaction_datetime', $transaction_datetime)->where('points_redeemed', $points_redeemed);
            $total_cleared_points = ClearedPoint::select('total_cleared_points')->where('member_id', $member_id)->sum('total_cleared_points');
            $check_member_id = ClearedPoint::select('total_cleared_points')->where('member_id', $member_id);
             
            if($check->exists() || $total_cleared_points < $points_redeemed){
              
                
                if($check->exists()){               
                    $exist = $check->select('member_id', 'points_redeemed', 'transaction_datetime')->first();
                    array_push($error, $exist);
                }
                if($check_member_id->exists()){
                    if($total_cleared_points < $points_redeemed){
                        $not_enough_points = ClearedPoint::select('member_id')->where('member_id', $member_id)->first();
                        array_push($error2, $not_enough_points);
                    }
                }
                if(!$check_member_id->exists()){
                    $member_id_not_exists = 'member_id:'.$member_id;
                    array_push($error_member_id, $member_id_not_exists);
                }
                

            }
           
            else{

                $redeempoints = Redeeming_Transaction::create([
                    'member_id' => $member_id,
                    'points_redeemed' => $points_redeemed,
                    'transaction_datetime' => $transaction_datetime,
                    'store_code' => $store_code,
                    'store_name' => $store_name,
                    'created_by' => $created_by
                ]);
                array_push($inserted_redeemedpoints, $redeempoints);
                array_push($error);

                ///////////Modified 01/06/2022//////////////
                $clearedpoint = ClearedPoint::where('member_id', $member_id);
                $update_cleared_points = ClearedPoint::where('member_id', $member_id)->update([
                    'total_cleared_points' => DB::raw('total_cleared_points - ' .$points_redeemed)
                ]);
                ///////////////////////////////////////////
            }          
        }
        // if((!count($inserted_redeemedpoints) > 0) || (count($inserted_redeemedpoints) > 0)){
        //     if(!count($inserted_redeemedpoints) > 0){
        //         $test1 =  response(['error' => ['message' => "Unable to Redeem!!", 'Redeemed_Transaction_Exists on' => $error, 'Not_Enough_Points on' => $error2]], 200);
        //     }
        //     if(count($inserted_redeemedpoints) > 0){
        //         $test2 = response(['message' => "Successfully Imported", 'Imported_Redeemed_Points' => $inserted_redeemedpoints], 200);
        //     }
        // }

        $message = "";
        if(count($inserted_redeemedpoints) > 0){
            $message = "Successfully Imported";
        }
        $error_message = "";
        if(count($error)> 0){
            $error_message = "Unable to Redeem!!, Transaction already Exists!!";
        }

        $error2_message = "";
        if(count($error2)> 0){
            $error2_message = "Unable to Redeem!!, Not Enough Point to Remeed!!";
        }

        $error3_message = "";
        if(count($error_member_id)> 0){
            $error3_message = "Member not Exist!!";
        }

     

        if((count($error_member_id)> 0) && (count($error)> 0) && (count($error2)> 0)){
            return response(['message'=> 'The given data was invalid.', 'error'=>['Member_not_Exist'=>$error_member_id,
            'Redeemed_Transaction_Exists' =>$error, 'Not_Enough_Points'=>$error2
            ]], 200);
        }


        if((count($error_member_id)> 0) && (count($error)> 0)){
            return response(['message'=> 'The given data was invalid.', 'error'=>['Member_not_Exist'=>$error_member_id,
            'Redeemed_Transaction_Exists' =>$error]], 200);
        }

        if((count($error_member_id)> 0) && (count($error2)> 0)){
            return response(['message'=> 'The given data was invalid.', 'error'=>['Member_not_Exist'=>$error_member_id,
            'Not_Enough_Points' =>$error2]], 200);
        }


        if((count($error)> 0)&&(count($error2)>0)){
            return response(['message'=> 'The given data was invalid.', 'error'=>['Redeemed_Transaction_Exists'=>$error,
            'Not_Enough_Points' =>$error2]], 200);
        }
        

        if(count($error_member_id)> 0){
           return response(['message'=> 'The given data was invalid.', 'error'=>['Member_not_Exist'=>$error_member_id]], 200);

        }

        if((count($error)> 0)){
            return response(['message'=> 'The given data was invalid.', 'error'=>['Redeemed_Transaction_Exists'=>$error]], 200);

        }

        if((count($error2)> 0)){
            return response(['message'=> 'The given data was invalid.', 'error'=>['Not_Enough_Points'=>$error2]], 200);
        }


    


    }

    public static function List_Redeeming_Transactions($redeemsperpage){
        $list = Redeeming_Transaction::select('redeeming_transactions.id', 'members.first_name', 'members.last_name', 'members.mobile_number', 'redeeming_transactions.store_name', 'redeeming_transactions.points_redeemed', 'redeeming_transactions.transaction_datetime')
        ->leftJoin('members', function($join){
            $join->on('redeeming_transactions.member_id', 'members.id');
         })->orderBy('redeeming_transactions.created_at', 'DESC')->paginate($redeemsperpage);
         return $list;
    }

    public static function Search_Redeeming_Transactions($searchvalue, $redeemsperpage){
        $search = Redeeming_Transaction::select('redeeming_transactions.id','members.first_name', 'members.last_name', 'members.mobile_number', 'redeeming_transactions.points_redeemed', 'redeeming_transactions.transaction_datetime')
        ->leftJoin('members', function($join){
            $join->on('redeeming_transactions.member_id', 'members.id');
        })
        ->where('members.first_name', 'LIKE', "%{$searchvalue}%")
        ->orWhere('members.last_name', 'LIKE', "%{$searchvalue}%")
        ->orWhere('members.mobile_number', 'LIKE', "%{$searchvalue}%")
        ->orWhere('redeeming_transactions.points_redeemed', 'LIKE', "%{$searchvalue}%")
        ->orWhere('redeeming_transactions.transaction_datetime', 'LIKE', "%{$searchvalue}%")
        ->orderBy('redeeming_transactions.transaction_datetime', 'DESC')->paginate($redeemsperpage);;
        return $search;

    }
    

  
    

}