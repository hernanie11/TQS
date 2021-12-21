<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Http\Requests\MemberImportRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminte\Support\Facades\Auth;
use App\Services\MemberManagementServices;
use App\Imports\MemberImport;
use Maatwebsite\Excel\Facades\Excel;



class MemberManagementController extends Controller
{
    public function Member(Request $request){
        $membersperpage = $request->membersperpage;
        $member = MemberManagementServices::List_Member($membersperpage);
        return $member;
    }

    public function CreateMember(MemberRequest $request){
        $first_name = ucwords($request->first_name);
        $last_name = ucfirst($request->last_name);
        $gender = $request->gender;
        $birthday = $request->birthday;
        $barangay = ucfirst($request->barangay);
        $municipality = ucfirst($request->municipality);
        $province = ucfirst($request->province);
        $email = $request->email;
        $mobile_number = $request->mobile_number;
        $created_by = auth('sanctum')->user()->id;
        
        $createmember = MemberManagementServices::Create_Member($first_name, $last_name, $gender, $birthday, $barangay, $municipality, $province, $email, $mobile_number, $created_by);
        return $createmember;
    }

    public function UpadateMemberStatus(Request $request){
        $id = $request->id;
        $is_active = $request->is_active;
        $updatestatus = MemberManagementServices::Upadate_Member_Status($id, $is_active);
        return $updatestatus;      
    }

    public function SearchMember(Request $request){
        $searchvalue = $request->searchvalue;
        $membersperpage = $request->membersperpage;
        $search_member = MemberManagementServices::Search_Member($searchvalue, $membersperpage);
        return $search_member;
    }

    public function UpdateMember(Request $request){
        $all = $request->all();
 
        $first_name = ucwords($request->first_name);
        $last_name = ucfirst($request->last_name);
        $gender = $request->gender;
        $birthday = $request->birthday;
        $barangay = ucfirst($request->barangay);
        $municipality = ucfirst($request->municipality);
        $province = ucfirst($request->province);
        $email = $request->email;
        $mobile_number = $request->mobile_number;
        $id = $request->id;
        $updatemember = MemberManagementServices::Update_Member($id, $all, $first_name, $last_name, $gender, $birthday, $barangay, $municipality, $province, $email, $mobile_number);
        return $updatemember;
    }

    public function GetMemberbyId(Request $request){
        $id = $request->id;
        $getmemberbyid = MemberManagementServices::Get_Member_by_Id($id);
        return $getmemberbyid;
    }

    public function import(Request $request) {
        $file = $request->file('file')->store('import');
        // Excel::import(new MemberImport,$file);  
        //(new MemberImport)->import($file);
        $import = new MemberImport;
        $import->import($file);
        dd($import->errors());
        return back()->withStatus('Excel file Imported'); 
    }

    public function ImportMember(MemberImportRequest $request){
        $all = $request->all();
        $created_by = auth('sanctum')->user()->id;
        // $all2 = $request->all();

        // $first_name = $request->first_name;
        // $last_name = ucfirst($request->last_name);
        // $gender = $request->gender;
        // $birthday = $request->birthday;
        // $barangay = ucfirst($request->barangay);
        // $municipality = ucfirst($request->municipality);
        // $province = ucfirst($request->province);
        // $email = $request->email;
        // $mobile_number = $request->mobile_number;
        
        $upload =  MemberManagementServices::Import_Member($all, $created_by);
        return $upload;
        

    }

    public function CheckMember(Request $request){
        $all = $request->all();
        $check =  MemberManagementServices::Check_Members($all);
        return $check;
        

    }

    
}
