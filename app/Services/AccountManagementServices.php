<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Business_Category;
use App\Models\Store;
use App\Models\User;
use App\Models\Account_Role;
use Illuminate\Http\Request;


class AccountManagementServices
{
    public static function UpdateAccount_Status($id, $action){
        $update = User::find($id);
        if(User::where('id', $id)->exists()){
            if($action == "Activate"){
            $update->update([
                'is_active' => true
            ]);
            return response([
                'message' => 'User Account is Successfully Activated',  'isActivated' => true] , 200);
            }

            if($action == "Deactivate"){
                $update->update([
                    'is_active' => false
                ]);
                return response([
                    'message' => 'User Account is Successfully Deactivated',  'isDeactivated' => true] , 200);
                
                }
        }
        else {
            return response([
                'message' => 'No User Found!'] , 200);
        }

        
    }

    public static function SearchAccount($searchvalue, $accountsperpage){
        $search = User::select('id', 'first_name', 'last_name', 'username', 'is_active', 'created_at')
        ->where('first_name', 'LIKE', "%{$searchvalue}%")
        ->orWhere('last_name', 'LIKE', "%{$searchvalue}%")
        ->orderBy('created_at', 'DESC')
        ->paginate($accountsperpage);
        if($search == NULL){
            return [];
        }
        else {
            return $search;
        }


    }

    public static function ListAccount($accountsperpage){
        $list = User::select('users.id','users.first_name', 'users.last_name', 'users.username', 'users.is_active', 'users.created_at', 'account_roles.role', 'account_roles.access_permission')
        ->leftJoin('account_roles', function($join){
            $join->on('users.id', 'account_roles.user_id');
        })->orderBy('users.created_at', 'DESC')->paginate($accountsperpage);
        return $list; 
    }

    public static function Update_Account($id, $first_name, $last_name, $username, $role, $access_permission){
        $acessConvertedToString = implode(", ",$access_permission);
        $access = json_encode($acessConvertedToString);
    //    $updateuser = User::leftJoin('account_roles', function($join){
    //     $join->on('users.id', 'account_roles.user_id');
    //    })->where('users.id', $id)
    //    ->update(['users.first_name' => $first_name,
    //              'users.last_name' => $last_name,
    //              'users.username' => $username,
    //              'account_roles.role' => $role,
    //              'account_roles.access_permission' => $acessConvertedToString]);

   
       $updateuser = User::find($id);
       if(User::where('id', $id)->exists()){
           if(User::where('id', '!=', $id)->where('username', $username)->exists()){
            return response([
                'message' => 'Username Already Exist!', 'isUpdated' => false] , 200);
           }
           else{
                $updateuser->update([
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'username' => $username,                     
                ]);

                $updaterole = Account_Role::where('user_id', $id)->update([
                    'role' => $role,
                    'access_permission' =>  $access
                    
                    
                ]);   

                return response([
                    'message' => 'User Account is Successfully Updated!',  'isUpdated' => true] , 200);

            }
       }
       else {
        return response([
            'message' => 'No User Found!'] , 200);
       }
        
    }
    
    public static function Get_User_Account_By_Id($id){
        $getuser = User::find($id);
        if($getuser == NULL){
           
            return response([
                'message' => 'Username Not Found!!',  'isUserExist' => false] , 200);
        }
        else{
            $user = User::select('users.first_name', 'users.last_name', 'users.username', 'users.password',  'account_roles.role', 'account_roles.access_permission')
            ->leftJoin('account_roles', function($join){
                $join->on('users.id', 'account_roles.user_id');
            })->where('users.id', $id)->get()->first();

            $response = [
                'user' => $user
            ];

            return response([
             'data' => $response, 'message' => 'Username Found', 'isUserExist' => true] , 200);
        }
     
    }

    public static function Reset_Password($id){
        $password = "1234";
        $hashpass = Hash::make($password);
        $update = User::where('id', $id)->update(['password' => $hashpass]);
        return response()->json([
         'message' => 'User Password is Successfully Reset!',  'isReset' => true] , 200);
    }




    
}