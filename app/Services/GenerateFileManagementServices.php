<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Redeeming_Transaction;
use App\Models\Member;
use App\Models\User;
use App\Models\Store;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminte\Support\Facades\Auth;

class GenerateFileManagementServices{
    public static function GenerateFile($user, $member, $store, $settings){
        // if($user == TRUE){
        //     $userdata = User::get();
        //     $user_response['userdata'] = $userdata; 
        // }
        // if($member == TRUE){
        //     $memberdata = Member::get();
        //     $member_response['memberdata'] = $memberdata; 
        // }
        // if($store == TRUE){
        //     $storedata = Store::get();
        // }
        // if($settings == TRUE){
        //     $settingdata = Setting::first();
        // }
       
        // return response()->json([$user_response, $member_response]);



        if(($user == TRUE) && ($member == FALSE) && ($store == FALSE) && ($settings == FALSE)){
            $userdata = User::get();
            return response()->json(['userdata' => $userdata]);
        }

        if(($user == FALSE) && ($member == TRUE) && ($store == FALSE) && ($settings == FALSE)){
            $memberdata = Member::get();
            return response()->json(['memberdata' => $memberdata]);
        }

        if(($user == FALSE) && ($member == FALSE) && ($store == TRUE) && ($settings == FALSE)){
            $storedata = Store::get();
            return response()->json(['storedata' => $storedata]);
        }

        if(($user == FALSE) && ($member == FALSE) && ($store == FALSE) && ($settings == TRUE)){
            $settingdata = Setting::first();
            return response()->json(['settingsdata' => $settingdata]);
        }



        if(($user == TRUE) && ($member == TRUE) && ($store == FALSE) && ($settings == FALSE)){
            $userdata = User::get();
            $memberdata = Member::get();
            return response()->json(['userdata' => $userdata, 'memberdata' => $memberdata]);
        }

        if(($user == TRUE) && ($member == FALSE) && ($store == TRUE) && ($settings == FALSE)){
            $userdata = User::get();
            $storedata = Store::get();
            return response()->json(['userdata' => $userdata, 'storedata' => $storedata]);
        }

        if(($user == FALSE) && ($member == TRUE) && ($store == TRUE) && ($settings == FALSE)){
            $memberdata = Member::get();
            $storedata = Store::get();
            return response()->json(['memberdata' => $memberdata, 'storedata' => $storedata]);
        }

        
        if(($user == TRUE) && ($member == FALSE) && ($store == FALSE) && ($settings == TRUE)){
            $userdata = User::get();
            $settingdata = Setting::first();
            return response()->json(['userdata' => $userdata, 'settingdata' => $settingdata]);
        }

        if(($user == FALSE) && ($member == TRUE) && ($store == FALSE) && ($settings == TRUE)){
            $memberdata = Member::get();
            $settingdata = Setting::first();
            return response()->json(['memberdata' => $memberdata, 'settingdata' => $settingdata]);
        }

        if(($user == FALSE) && ($member == FALSE) && ($store == TRUE) && ($settings == TRUE)){
            $storedata = Store::get();
            $settingdata = Setting::first();
            return response()->json(['storedata' => $storedata, 'settingdata' => $settingdata]);
        }

        if(($user == TRUE) && ($member == TRUE) && ($store == TRUE) && ($settings == TRUE)){
            $userdata = User::get();
            $memberdata = Member::get();
            $storedata = Store::get();
            $settingdata = Setting::first();
            return response()->json(['userdata' => $userdata, 'memberdata' => $memberdata, 'storedata' => $storedata, 'settingdata' => $settingdata]);
        }

    }


}