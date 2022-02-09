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
        if(Setting::select('earning_percentage')->where('earning_percentage', $set_percentage)->exists()){
            return response()->json(['code' => '409', 'message' => 'No Changes'], 409);
        }
        else{
            if(empty($settings)){
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

   

}
