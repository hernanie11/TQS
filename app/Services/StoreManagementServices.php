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
           // $test_business_model = preg_replace("/[^A-Z]+/", "", $code);
           if(!Business_Category::where('name',$business_model)->exists()){
               return response()->json(['message'=>'The given data was invalid.', 'error'=>['data'=>'Business Category not exists!']]);
           }
            $business_category = Business_Category::select('id')->where('name',$business_model)->first();
            
        $store = Store::create([
            'businesscategory_id' => $business_category->id,
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
        return response()->json(['code'=> '201','message' => 'Store Successfully created', 'isCreated' => true],201);     
  
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
           
    }
   

    public static function Regenerate_Token(){
        $new_token = (new Token())->Unique('stores', 'token', 60);
        $response = [
            'newtoken' => $new_token
        ];

        return response([
         'data' => $response] , 200);

    }


    //TQSclient

    public static function Get_Stores(){
        $store = Store::select('id', 'code', 'name')->where('is_activated',0)->get();
        return $store;
    }

    public static function Validated_Store($id, $token){
        $store = Store::where('id', $id)->where('token', $token);
        if($store->exists()){
          //  $store->update(['is_activated' => true]);
            return response()->json(['message'=>'Token is valid', 'valid'=>true],200);
        }
        else{
            return response()->json(['message'=>'Token is not valid', 'valid'=>false],422);
        }

    }

    
}