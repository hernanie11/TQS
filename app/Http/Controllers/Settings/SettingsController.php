<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Setting_Log;
use App\Http\Requests\SettingsRequest;


class SettingsController extends Controller
{
    public function set_earned_points_percentage(SettingsRequest $request){
        $set_percentage = $request->set_percentage;
        $user_id = Auth()->user()->id;
        $remarks = $request->remarks;
        $settings = Setting::select('earning_percentage')->first();
        if($settings->where('earning_percentage', $set_percentage)->exists()){
            return response()->json(['code' => '409', 'message' => 'No Changes'], 409);
        }
        else{
            if($settings == null){
                $create = Setting::create([
                    'earning_percentage' => $set_percentage,   
                ]);

                $logs = Setting_Log::create([
                    'user_id' => $user_id,
                    'remarks' => 'Created',
                    'action' => 'Created'  
                ]);

                return response()->json(['code' => '201', 'message' => 'Created Successfully', 'data' => $create], 201);
            }
            if($settings != null){
                $update = Setting::whereNotNull('id')
                ->update(['earning_percentage' => $set_percentage]);
                $logs = Setting_Log::create([
                    'user_id' => $user_id,
                    'remarks' => $remarks,
                    'action' => 'Updated'  
                ]);

                return response()->json(['updated_percentage'=>$set_percentage,'code' => '200', 'message' => 'Updated Successfully'], 200);

            }
        }
      
    }


    public function Get_Settings(){
        $get = Setting::first();
        // $response = [];
        // $response['currentPercentage'] = $get['earning_percentage'];
        // $response['statusCode'] = 200;
        return response()->json($get);
    }

    public function get_logs(Request $request){
      
        // $test = Setting_Log::select('user_id')->chunk(50, function($get)
        // {
        //     foreach ($get as $gets)
        //     {
             
               
        //     }
          
        // });

        // return $test;

        // $colors = Setting_Log::select('id')->get();
        // $chunks = $colors->chunk(100);
 
        // // return($chunks[0]);
        // $test = array();

        // foreach (Setting_Log::select('id')->cursor() as $flight) {
        //     array_push($test,$flight);
        // }
        // return $test;
        
    $id = $request->id;
     $set = Setting_Log::select('id','remarks')->where('id', $id)->firstOrFail();
     return $set;
    //  try{
    //      $set = Setting_Log::where('id', $id)->firstOrFail();
    //      return $set;

    //  }
    //  catch (\Exception $exception){
      
    //  }
     
    
 
        
    }

}
