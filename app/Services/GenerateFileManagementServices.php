<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Redeeming_Transaction;
use App\Models\Member;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminte\Support\Facades\Auth;

class GenerateFileManagementServices{
    public static function GenerateFile($user, $member, $store){
        if(($user == TRUE) && ($member == FALSE) && ($store == FALSE)){
            $userdata = User::get();
            return response()->json(['userdata' => $userdata]);
        }

        if(($user == FALSE) && ($member == TRUE) && ($store == FALSE)){
            $memberdata = Member::get();
            return response()->json(['memberdata' => $memberdata]);
        }

        if(($user == FALSE) && ($member == FALSE) && ($store == TRUE)){
            $storedata = Store::get();
            return response()->json(['storedata' => $storedata]);
        }

        if(($user == TRUE) && ($member == TRUE) && ($store == FALSE)){
            $userdata = User::get();
            $memberdata = Member::get();
            return response()->json(['userdata' => $userdata, 'memberdata' => $memberdata]);
        }

        if(($user == TRUE) && ($member == FALSE) && ($store == TRUE)){
            $userdata = User::get();
            $storedata = Store::get();
            return response()->json(['userdata' => $userdata, 'storedata' => $storedata]);
        }

        if(($user == FALSE) && ($member == TRUE) && ($store == TRUE)){
            $memberdata = Member::get();
            $storedata = Store::get();
            return response()->json(['memberdata' => $memberdata, 'storedata' => $storedata]);
        }

        if(($user == TRUE) && ($member == TRUE) && ($store == TRUE)){
            $userdata = User::get();
            $memberdata = Member::get();
            $storedata = Store::get();
            return response()->json(['userdata' => $userdata, 'memberdata' => $memberdata, 'storedata' => $storedata]);
        }

        

    }
}