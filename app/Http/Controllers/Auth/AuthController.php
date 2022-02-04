<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Access;
use App\Models\Account_Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminte\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegistrationRequest;



class AuthController extends Controller
{
    public function CreateAccount(RegistrationRequest $request){
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $username = $request->username;
        $password = $request->password;
        $role = $request->role;
        $access_permission = $request->access_permission;
        $acessConvertedToString = implode(", ",$access_permission);
        $converted = json_encode($acessConvertedToString);
       // $stringtojson = json_encode($acessConvertedToString);

   
    //   if($role == "admin"){
    //       foreach($access_permission as $access){
    //         if($access == "earning"){
    //             $ace = "earning";
    //             if(Access::where('role', $role)->where('access', $ace)->exists()){        
    //             }
    //             else {
    //                 return response([
    //                          'message' => 'Earning access not assigneable to role admin '], 200);
    //             }
    //         }
    //       }
    //   }

    // if(($role != "admin") and ($role != "cashier")){
    //     return response([
    //         'error_message' => $role . ' is not a value'], 200);
    // }
   
    if($role == "admin"){

        foreach($access_permission as $access){
            if(($access != "members") and($access != "user-accounts") and ($access != "stores") and ($access != "earned-points") and ($access != "redeemed-points") and ($access != "generate-file")){
                return response([
                    'error_message' => 'No such '.$access .' value'], 200);
            }
        
          if($access == "earning"){
              return response([
                  'message' => 'Earning access not assigneable to role admin '], 200);
          }

          if($access == "transactions"){
            return response([
                'message' => 'Transaction access not assigneable to role admin '], 200);
        }
          
        }
    }

      if($role == "cashier"){

          foreach($access_permission as $access){

            if(($access != "earning") and($access != "redeeming") and ($access != "members") and ($access != "transactions") and ($access != "generate-file")){
                return response([
                    'error_message' => 'No such '.$access .' value'], 200);
            }
        
            if($access == "user-accounts"){
                return response([
                    'message' => 'User-account access not assigneable to role cashier '], 200);
            }
          
            if($access == "stores"){
                return response([
                    'message' => 'store access not assigneable to role cashier '], 200);
            }
           
            if($access == "redeemed-points"){
                return response([
                    'message' => 'Redeemed-Points access not assigneable to role cashier '], 200);
            }

            if($access == "earned-points"){
                return response([
                    'message' => 'Earned-Points access not assigneable to role cashier '], 200);
            }
          }
      }
       
      
        if(User::where('username', $username)->exists()){
            $response = [
                'is_created' => false
            ];
            return response([
                'message' => 'Username Already Exists!!',  'data' => $response] , 200);
        }

        else{
            $user = User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'username' => $username,
                'password' =>  Hash::make($password),
                'is_active' => 1
            ]); 

            $userid = $user->id;
            $account_roles = Account_Role::create([
                'user_id' => $userid,
                'role' => $role,
                'access_permission' => $acessConvertedToString
            ]);

            $response = [
                'user' => $user,
                'is_created' => true
            ];
            return response()->json(['message' => 'Successfully created', 'data' => $response]);
        }
    }

    public function login(AuthRequest $request){
        $username = $request->username;
        $password = $request->password;        

        $user = User::select('users.id','users.first_name', 'users.last_name', 'users.username', 'users.password', 'account_roles.user_id', 'account_roles.role', 'account_roles.access_permission')
        ->leftJoin('account_roles', function($join){
            $join->on('users.id', 'account_roles.user_id');
        })->where('username', $username)->first();

        if(!$user || !Hash::check($password, $user->password)) {
            return response([
                'message' => 'Username or Password is incorrect!! ',
                'isAuthenticated' => false
            ], 200);
        } 
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        
        return response([
            'message' => 'Successfully Logged In',
            'isAuthenticated' => true,
            'data' => $response
        ], 200);
     
    }

    public function logout(Request $request){  
     //   auth('sanctum')->user()->tokens()->delete();//logout all tokens by user_id
        auth('sanctum')->user()->currentAccessToken()->delete();//logout currentAccessToken
        return response()->json(['message' => 'You are Successfully Logged Out!']);
    }

    public function access_permission(Request $request){
        $rectoken = $request->token;
        $token = $request->bearerToken();

       if($token == $rectoken){
           return response([
               'isLoggedIn' => true
           ], 200);
       }
       else{
           return response([
               'isLoggedIn' => false
           ],200);
       
       }
    }
}
