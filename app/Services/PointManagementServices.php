<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\EarnedPoint;
use App\Models\User;
use Illuminate\Http\Request;

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
        // $list = Point::select('member_id', 'points', 'created_at')->orderBy('id', 'DESC')->paginate($pointsperpage);
        // return $list;
        $list = EarnedPoint::select('earnedpoints.id','members.first_name', 'members.last_name', 'members.mobile_number','earnedpoints.transaction_no', 'earnedpoints.amount', 'earnedpoints.points_earn', 'earnedpoints.transaction_datetime')
         ->leftJoin('members', function($join){
             $join->on('earnedpoints.member_id', 'members.id');
         })->orderBy('earnedpoints.transaction_datetime', 'DESC')->paginate($pointsperpage);;
         return $list;
    } 
    

    
}
 