<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Business_Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;

class MemberManagementServices
{
    public static function List_Member($membersperpage){
        $list = Member::select('id', 'first_name', 'last_name', 'gender', 'birthday', 'barangay', 'municipality', 'province', 'email', 'mobile_number', DB::raw('if(is_active = 1, "Active", "Inactive") as status'), 'created_at')->orderBy('id', 'DESC')->paginate($membersperpage);
        return $list; 
    }

    public static function Create_Member($first_name, $last_name, $gender, $birthday, $barangay, $municipality, $province, $email, $mobile_number, $created_by){
        if(Member::where('mobile_number', $mobile_number)->exists()){
            return response([
                'message' => 'Mobile Number Already Exists!'
            ], 200);
        }
        else{
            if(($gender != "male") and ($gender != "female")){
                return response([
                    'error_message' => $gender . ' is not a value'], 200);
            }
            else{
            
                $member = Member::create([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'gender' => $gender,
                    'birthday' => $birthday,
                    'barangay' => $barangay,
                    'municipality' => $municipality,
                    'province' => $province,
                    'email' => $email,
                    'mobile_number' => $mobile_number,
                    'is_active' => true,
                    'created_by' => $created_by              
                ]);
                
                $response = [
                    'member' => $member
                ];

                return response([
                'data' => $response, 'message' => 'Member is Successfully Created!'] , 200);
            }
        }
    }

    public static function Upadate_Member_Status($id, $is_active){
        $update = Member::find($id);
        if(Member::where('id', $id)->exists()){
            $update->update([
                'is_active' => $is_active
            ]);
            if($is_active == true){
                return response([
                    'message' => 'Member is Successfully Activated',  'isActivated' => true] , 200);
            }
            if($is_active == false){
                return response([
                    'message' => 'Member is Successfully Deactivated',  'isDeactivated' => true] , 200);
            }
        }
        else {
            return response([
                'message' => 'No Member Found!'] , 200);
           }
    }

    public static function Search_Member($searchvalue, $membersperpage){
        $search = Member::select('id', 'first_name', 'last_name', 'gender', 'birthday', 'barangay', 'municipality', 'province', 'email', 'mobile_number', DB::raw('if(is_active = 1, "Active", "Inactive") as status'), 'created_at')
        ->where('first_name', 'LIKE', "%{$searchvalue}%")
        ->orWhere('last_name', 'LIKE', "%{$searchvalue}%")
        ->orWhere('gender', 'LIKE', "%{$searchvalue}%")
        ->orWhere('birthday', 'LIKE', "%{$searchvalue}%")
        ->orWhere('barangay', 'LIKE', "%{$searchvalue}%")
        ->orWhere('municipality', 'LIKE', "%{$searchvalue}%")
        ->orWhere('province', 'LIKE', "%{$searchvalue}%")
        ->orWhere('email', 'LIKE', "%{$searchvalue}%")
        ->orWhere('mobile_number', 'LIKE', "%{$searchvalue}%")
        ->orderBy('created_at', 'DESC')
        ->paginate($membersperpage);
        if($search == NULL){
            return [];
        }
        else {
            return $search;

        }

    }

    public static function Update_Member($id, $all, $first_name, $last_name, $gender, $birthday, $barangay, $municipality, $province, $email, $mobile_number){
        $updatemember = Member::find($id);
        if(Member::where('id', $id)->exists()){
            if(Member::where('mobile_number', $all)->where('id', '!=', $id)->exists()){
                return response([
                    'message' => 'Mobile Number Already Exist!', 'isUpdated' => false] , 200);
            }
            else{
                $updatemember->update([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'gender' => $gender,
                    'birthday' => $birthday,
                    'barangay' => $barangay,
                    'municipality' => $municipality,
                    'province' => $province,
                    'email' => $email,
                    'mobile_number' => $mobile_number,

                ]);
                return response([
                    'message' => 'Member is Successfully Updated!',  'isUpdated' => true] , 200);
            }
            
        } 
        else{
            return response([
                'message' => 'No Member Found!',  'isUpdated' => false] , 200);
        
        }

    }

    public static function Get_Member_by_Id($id){
        $getmember = Member::find($id);
        if($getmember == NULL){
            return response([
                'message' => 'Member Not Found!!',  'isMemberExist' => false] , 200);
        }
        else{
            $member = Member::select('first_name', 'last_name', 'gender', 'birthday', 'barangay', 'municipality', 'province', 'email', 'mobile_number', 'is_active', 'created_at')
            ->where('id', $id)->get()->first();
            $response = [
                'member' => $member
            ];

            return response([
             'data' => $response, 'message' => 'Member is Found', 'isMemberExist' => true] , 200);
        }
    }

    public static function Check_Members($all){
       $error = array();
       $data = array();
//$inserted_members = array();
       foreach($all as $mobileno){
            $mobile_no = $mobileno['mobile_number'];
            if(Member::where('mobile_number', $mobile_no )->exists()){
                $exist = Member::select('mobile_number')->where('mobile_number', $mobile_no)->first();
                array_push($error, $exist);
            }
      }
      return response(['memberExists' => $error]);
    }

    public static function Import_Member($all, $created_by){

        $count = 0;
        $error = array();
        $data = array();
       $inserted_members = array();

        foreach($all as $mobileno){
            $mobile_no = $mobileno['mobile_number'];
            $first_name = $mobileno['first_name'];
            $last_name = $mobileno['last_name'];
            $gender = $mobileno['gender'];
            $birthday = $mobileno['birthday'];
            $barangay = $mobileno['barangay'];
            $municipality = $mobileno['municipality'];
            $province = $mobileno['province'];
            $email = $mobileno['email'];
            $is_active = $mobileno['is_active'];
        

            if(Member::where('mobile_number', $mobile_no )->exists()){
                $exist = Member::select('mobile_number')->where('mobile_number', $mobile_no)->first();
               
    
                array_push($error, $exist);
              
            }
            else{
                
                $member =  DB::table('members')->insert([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'gender' => $gender,
                    'birthday' => $birthday,
                    'barangay' => $barangay,
                    'municipality' => $municipality,
                    'province' => $province,
                    'email' => $email,
                    'mobile_number' => $mobile_no,
                    'is_active' => $is_active,
                    'created_by' => $created_by
                ]);
            
                array_push($inserted_members, $mobileno);
                array_push($error);
            
            
            }
        }
        $message = "No Members are Imported";
        if(count($inserted_members) > 0){
            $message = "Members are Succesfully Imported";
        }
        return response(
            [
            'memberExists' => $error, 
            'message'=>$message, 
            'imported_members' => $inserted_members
        ], 200
        );

                
    }

    
}