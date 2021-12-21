<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Services\AccountManagementServices;



class AccountManagementController extends Controller
{
    public function Accounts(Request $request){
        $accountsperpage = $request->accountsperpage;
        $accounts = AccountManagementServices::ListAccount($accountsperpage);
        return $accounts;
    }

    public function Search(Request $request){
        $searchvalue = $request->searchvalue;
        $accountsperpage = $request->accountsperpage;
        $search_account = AccountManagementServices::SearchAccount($searchvalue, $accountsperpage);
        return $search_account;
    }

    public function UpdateStatus(Request $request){
        $action = $request->action;
        $id = $request->id;
        $update_account = AccountManagementServices::UpdateAccount_Status($id, $action);
        return $update_account;
    }

    public function GetUserAccountById(Request $request){
        $id = $request->id;
        $getuserbyid = AccountManagementServices::Get_User_Account_By_Id($id);
        return $getuserbyid;
    }

    public function UpdateAccount(Request $request){
        $all = $request->all();
         $first_name = $request->first_name;
         $last_name = $request->last_name;
         $username = $request->username;
         $role = $request->role;
         $access_permission = $request->access_permission;
       // 

        $id = $request->id;
       // $updateaccount = AccountManagementServices::Update_Account($id, $all);
        $updateaccount = AccountManagementServices::Update_Account($id, $first_name, $last_name, $username, $role, $access_permission);
       //$updateaccount = AccountManagementServices::Update_Account($id, $user, $role, $acessConvertedToString);
        return $updateaccount;
    }

    public function ResetPassword(Request $request){
        $id = $request->id;
        $reset = AccountManagementServices::Reset_Password($id);
        return $reset;
    }


    
}
