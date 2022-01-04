<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Business_Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Dirape\Token\Token;


class StoreManagementServices
{
    public static function Create_Business_Category($name){
        $business_category = Business_Category::create([
            'name' => $name,
            'is_active' => true
        ]);
        return $business_category;
    }

    public static function Get_Store_by_Id($id){
        $getstore = Store::find($id);
        if($getstore == NULL){
            return response([
                'message' => 'Store Not Found!!',  'isStoreExist' => false] , 200);
        }
        else{
            $store = Store::select('code', 'name', 'area', 'region', 'cluster', 'business_model', 'token')->where('id', $id)->get()->first();
            $response = [
                'store' => $store
            ];

            return response([
             'data' => $response, 'message' => 'Store is Found', 'isStoreExist' => true] , 200);
        }
    }

    public static function Create_Store($code, $name, $area, $region, $cluster, $business_model, $created_by){
        if(Store::where('code', $code)->exists()){
            return response()->json(['message' => 'Store Code Already Exists!!']);  
        }
        else {
            
            if(($business_model != "FO") and ($business_model != "FOX")){
                return response([
                    'error_message' => $business_model . ' is not a value'], 200);
            }
            else{
                $store = Store::create([
                    'businesscategory_id' => 1,
                    'code' => $code,
                    'name' =>  $name,
                    'area' => $area,
                    'region' => $region,
                    'cluster' => $cluster,
                    'business_model' => $business_model,
                    'token' => (new Token())->Unique('stores', 'token', 60),
                    'is_active' => true,
                    'created_by' => $created_by
                ]);
                //return $store;
                return response()->json(['message' => 'Store Successfully created', 'isCreated' => true]);     
           }

       }
    }

    public static function Update_Store_Status($id, $is_active){
        $update = Store::find($id);
        if(Store::where('id', $id)->exists()){
            $update->update([
                'is_active' => $is_active
            ]);
            if($is_active == true){
                return response([
                    'message' => 'Store is Successfully Activated',  'isActivated' => true] , 200);
            }
            if($is_active == false){
                return response([
                    'message' => 'Store is Successfully Deactivated',  'isDeactivated' => true] , 200);
            }
       }
       else {
        return response([
            'message' => 'No Store Found!'] , 200);
       }
    }

    public static function Update_Store($id, $all, $code){ 
        $updatestore = Store::find($id);
        if(Store::where('id', $id)->exists()){
            if(Store::where('code', $all)->where('id', '!=', $id)->exists()){
                return response([
                    'message' => 'Store Code Already Exist!', 'isUpdated' => false] , 200);
            }
            else{
                $updatestore->update($all);
                return response([
                    'message' => 'Store is Successfully Updated!',  'isUpdated' => true] , 200);
            }
            
        } 
        else{
            return response([
                'message' => 'No Store Found!',  'isUpdated' => false] , 200);
        
        }

    }

    public static function List_Store($storesperpage){
        $list = Store::select('id','code', 'name', 'area', 'region', 'cluster', 'business_model', DB::raw('if(is_active = 1, "Active", "Inactive") as status'), 'token', 'created_at')->orderBy('created_at', 'DESC')->paginate($storesperpage);
        return $list;
    }

    public static function Search_Store($searchvalue, $storesperpage){
        $search = Store::select('id', 'code', 'name', 'area', 'region', 'cluster', 'business_model', DB::raw('if(is_active = 1, "Active", "Inactive") as status'), 'token', 'created_at')
        ->where('code', 'LIKE', "%{$searchvalue}%")
        ->orWhere('name', 'LIKE', "%{$searchvalue}%")
        ->orWhere('area', 'LIKE', "%{$searchvalue}%")
        ->orWhere('region', 'LIKE', "%{$searchvalue}%")
        ->orWhere('cluster', 'LIKE', "%{$searchvalue}%")
        ->orderBy('created_at', 'DESC')
        ->paginate($storesperpage);
        if($search == NULL){
            return [];
        }
        else {
            return $search;

        }

        


        // if(isset($searchvalue)){
        //     $search = Store::select('id', 'code', 'name', 'area', 'region', 'cluster', 'business_model', DB::raw('if(is_active = 1, "Active", "Inactive") as status'), 'created_at')->where('name', 'LIKE', "%{$searchvalue}%")->first();
            
        //     if($search == true){
        //         $search = Store::select('id', 'code', 'name', 'area', 'region', 'cluster', 'business_model', DB::raw('if(is_active = 1, "Active", "Inactive") as status'), 'created_at')->where('name', 'LIKE', "%{$searchvalue}%")->get();
        //         return $search;
        //     }
        //     if($search == NULL){
        //         $area = Store::where('area', 'LIKE', "%{$searchvalue}%")->first();
        //         $code = Store::where('code', 'LIKE', "%{$searchvalue}%")->first();
        //         $region = Store::where('region', 'LIKE', "%{$searchvalue}%")->first();
        //         $cluster = Store::where('cluster', 'LIKE', "%{$searchvalue}%")->first();
                
        //         if($area != NULL){
        //             $area = Store::select('id', 'code', 'name', 'area', 'region', 'cluster', 'business_model', DB::raw('if(is_active = 1, "Active", "Inactive") as status'), 'created_at')->where('area', 'LIKE', "%{$searchvalue}%")->get();
        //             return $area;
        //         }
        //         if($code != NULL){
        //             $code = Store::select('id', 'code', 'name', 'area', 'region', 'cluster', 'business_model', DB::raw('if(is_active = 1, "Active", "Inactive") as status'), 'created_at')->where('code', 'LIKE', "%{$searchvalue}%")->get();
        //             return $code;
        //         }
        //         if($region != NULL){
        //             $region = Store::select('id', 'code', 'name', 'area', 'region', 'cluster', 'business_model', DB::raw('if(is_active = 1, "Active", "Inactive") as status'), 'created_at')->where('region', 'LIKE', "%{$searchvalue}%")->get();
        //             return $region;
        //         }
            
        //         if($cluster != NULL){
        //             $cluster = Store::select('id', 'code', 'name', 'area', 'region', 'cluster', 'business_model', DB::raw('if(is_active = 1, "Active", "Inactive") as status'), 'created_at')->where('cluster', 'LIKE', "%{$searchvalue}%")->get();
        //             return $cluster;
        //         }

        //         if(($area == NULL) and ($code == NULL) and ($region == NULL) and ($cluster == NULL)){
        //             return [];
        //         }

        //     }
        
        // }
           
    }
   

    public static function Regenerate_Token(){
        $new_token = (new Token())->Unique('stores', 'token', 60);
        $response = [
            'newtoken' => $new_token
        ];

        return response([
         'data' => $response] , 200);

    }
}