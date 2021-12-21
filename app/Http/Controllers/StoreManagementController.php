<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Business_Category;
use App\Services\StoreManagementServices;
use Illuminte\Support\Facades\Auth;
use App\Http\Requests\StoreRequest;

class StoreManagementController extends Controller
{
    public function CreateBusiness(Request $request){
        $name = $request->name;
        $create = StoreManagementServices::Create_Business_Category($name);
        return $create;
    }

    public function GetStorebyId(Request $request){
        $id = $request->id;
        $getstorebyid = StoreManagementServices:: Get_Store_by_Id($id);
        return $getstorebyid;

    }

    public function CreateStore(StoreRequest $request){
       // $businesscategory_id = $request->businesscategory_id;
        $code = strtoupper($request->code);
        $name = ucfirst($request->name);
        $area = ucfirst($request->area);
        $region = ucfirst($request->region);
        $cluster = ucfirst($request->cluster);
        $business_model = $request->business_model;
        $created_by = auth('sanctum')->user()->id;
        $createstore = StoreManagementServices::Create_Store($code, $name, $area, $region, $cluster, $business_model, $created_by);
        return $createstore;
    }

    public function UpdateStoreStatus(Request $request){
        $id = $request->id;
        $is_active = $request->is_active;
        $updatestatus = StoreManagementServices::Update_Store_Status($id, $is_active);
        return $updatestatus;
    }

    public function UpdateStore(Request $request){
        $id = $request->id;
        $all = $request->all();
        $code = $request->code;
        $update = StoreManagementServices::Update_Store($id, $all, $code);
        return $update;

    }

    public function Stores(Request $request){
        $storesperpage = $request->storesperpage;
        $stores = StoreManagementServices::List_Store($storesperpage);
        return $stores;
    }

    public function SearchStore(Request $request){
        $searchvalue = $request->searchvalue;
        $storesperpage = $request->storesperpage;
        $search_store = StoreManagementServices::Search_Store($searchvalue, $storesperpage);
        return $search_store;
    }

    public function RegenerateToken(){
        $token = StoreManagementServices::Regenerate_Token();
        return $token;
    }
}
