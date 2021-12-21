<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;

class PointManagementServices{
    public static function List_Member_Points($member_id){
         $list = Point::select('points.member_id', 'points.points', 'points.created_at', 'members.first_name', 'members.last_name', 'members.mobile_number')
         ->leftJoin('members', function($join){
             $join->on('points.member_id', 'members.id');
         })->where('points.member_id', $member_id)->orderBy('points.created_at', 'DESC');
         return $list;
    } 

    public static function Sum_Points_by_Member($member_id){
        $sum = Point::select(DB::raw('SUM(`points`)'))->where('member_id', $member_id)->first();
        return $sum;
    }

    public static function List_Points_Transaction($pointssperpage){
        $list = Point::select('member_id', 'points', 'created_at')->orderBy('id', 'DESC')->paginate($pointssperpage);
        return $list;
    }

    
}
 