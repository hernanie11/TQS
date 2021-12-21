<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminte\Support\Facades\Auth;
use App\Services\MemberManagementServices;

class MemberController extends Controller
{
    public function Member(){
        $member = MemberManagementServices::List_Member();
        return $member;
    }

    public function CreateMember(Request $request){
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $gender = $request->gender;
        $birthday = $request->birthday;
        $barangay = $request->barangay;
        $municipality = $request->muncipality;
        $province = $request->province;
        $email = $request->email;
        $mobile_number = $request->mobile_number;
        $created_by = auth('sanctum')->user()->id;
        
        $createmember = MemberManagementServices::Create_Member($first_name, $last_name, $gender, $birthday, $barangay, $municipality, $province, $email, $mobile_number, $created_by);
        return $createmember;
    
    }
}
