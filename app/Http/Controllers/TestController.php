<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Account;
use App\Models\Account_Role;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function Test(){
        $test = new Store;
        $test->businesscategory_id = 5;
        $test->code = '1001';
        $test->name = 'FreshTest';
        $test->area = 'Mexico';
        $test->region = 'region3';
        $test->cluster = 'cluster1';
        $test->business_model = 'FO';
        $test->token = 'sdfsadf23hsdfsdfsdfsd21312';
        $test->is_active = 1;
        $test->created_by = '10790';
        $test->save();
        return $test;
        
    }

    public function Test2(){
        $test2 = new Account;
        $test2->first_name = 'Hernanie';
        $test2->last_name = 'Pabustan';
        $test2->username = 'roy12345';
        $test2->password = '121345678';
        $test2->is_active = 1;
        $test2->created_by = '10790';
        $test2->save();
        return $test2;
    }

    public function Test3(){
        
       
        $test3 = new Account_Role;
        $test3->account_id = 1;
        $test3->role = 'Admin';
        $test3->access_permission = ["Points, Member"];
        $test3->save();
        return $test3;
    }
}
