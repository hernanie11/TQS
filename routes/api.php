<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AccountManagementController;
use App\Http\Controllers\StoreManagementController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberManagementController;
use App\Http\Controllers\PointManagementController;
use App\Http\Controllers\RedeemManagementController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('members', [MemberController::class, 'Member']);
//Route::post('create_member', [MemberController::class, 'CreateMember']);


Route::post('register', [AuthController::class, 'CreateAccount']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);


Route::group(['middleware' => ['auth:sanctum']], function() {
   Route::post('isLoggedIn', [AuthController::class, 'access_permission']); //Authentication
   
   Route::group(['prefix' => 'admin', 'middleware' => ['auth' => 'admin']], function(){
        
        //account management
        Route::post('/accounts/create', [AuthController::class, 'CreateAccount']); //create user account
        Route::get('/accounts/{accountsperpage}', [AccountManagementController::class, 'Accounts']); //Show all Accounts
        Route::post('/accounts/search/{accountsperpage}', [AccountManagementController::class, 'Search']); // Search Accounts
        Route::put('/accounts/update-account/{id}', [AccountManagementController::class, 'UpdateAccount']); //Update Account
        Route::put('/accounts/update-account-status/{id}', [AccountManagementController::class, 'UpdateStatus']); //Update Account Status
        Route::get('/accounts/getuserbyid/{id}', [AccountManagementController::class, 'GetUserAccountById']); //Get User Account by Id 
        Route::put('/accounts/reset-password/{id}', [AccountManagementController::class, 'ResetPassword']); //Reset Password
        //
        //store management
        Route::post('/business-category', [StoreManagementController::class, 'CreateBusiness']); //CreatNewBusinessCategory
        Route::get('/stores/{storesperpage}', [StoreManagementController::class, 'Stores']); //show all stores w/ pagination
        Route::post('/create-store', [StoreManagementController::class, 'CreateStore']); //CreateNewStore w/ token
        Route::post('/store/search/{storesperpage}', [StoreManagementController::class, 'SearchStore']);
        Route::put('/update-store-status/{id}', [StoreManagementController::class, 'UpdateStoreStatus']); //Update Store Status
        Route::get('/store/getstorebyid/{id}', [StoreManagementController::class, 'GetStorebyId']); //Get Store by Id
        Route::put('/update-store/{id}', [StoreManagementController::class, 'UpdateStore']); //Update Store 
        Route::get('/store/regenerate-token', [StoreManagementController::class, 'RegenerateToken']); //regenerate token

        //
       //Member Management
        Route::get('/members/{membersperpage}', [MemberManagementController::class, 'Member']); //Show all Members w/ pagination ok
        Route::post('/create-member', [MemberManagementController::class, 'CreateMember']); //Create New Member ok
        Route::post('/search-member/{membersperpage}', [MemberManagementController::class, 'SearchMember']); //Search Member ok
        Route::put('/update-member-status/{id}', [MemberManagementController::class, 'UpadateMemberStatus']); //Update Member Status ok
        Route::put('/update-member/{id}', [MemberManagementController::class, 'UpdateMember']); //Update Member Status ok
        Route::get('/member/getmemberbyid/{id}', [MemberManagementController::class, 'GetMemberbyId']); //Get User Account by Id ok
        Route::post('/import', [MemberManagementController::class, 'import'])->name('import'); //using laravel-excel
        Route::post('/member/import-members', [MemberManagementController::class, 'ImportMember']); //custom import
        Route::post('/member/check-members', [MemberManagementController::class, 'CheckMember']); //custom import

        //EarnedPoints Management
        Route::get('/earnedpoints/{pointsperpage}', [PointManagementController::class, 'ListPointsTransaction']); //List all Earned points Transactions with pagination
        Route::get('/points/{member_id}', [PointManagementController::class, 'ListMemberPoints']);
        Route::get('/points/totalpoints/{member_id}', [PointManagementController::class, 'SumPointsbyMember']);

       
        Route::post('/points/import', [PointManagementController::class, 'ImportEarnedPoints']);//import
        Route::post('/points/check', [PointManagementController::class, 'CheckEarnedPoints']);//check 
        Route::post('/search-earnedpoints/{pointsperpage}', [PointManagementController::class, 'SearchEarnedPoints']);//search 

        Route::post('/test/points', [PointManagementController::class, 'Create']); //test only

        //RedeemPoints Management
        Route::post('/redeem-request', [RedeemManagementController::class, 'Create']);
        Route::post('/redeem/check', [RedeemManagementController::class, 'Check']);
        Route::post('/redeem/import', [RedeemManagementController::class, 'Import']);

        Route::post('/logout', [AuthController::class, 'logout']);
   });



   Route::group(['prefix' => 'cashier', 'middleware' => ['auth' => 'cashier']], function(){

        Route::get('/isLoggedIn', fn() =>'Welcome Cashier');
        Route::post('/logout', [AuthController::class, 'logout']);
   });



});



















Route::post('createaccount', [AccountManagementController::class, 'Create']);
Route::post('business_category', [StoreManagementController::class, 'CreateBusiness']);
Route::post('store', [StoreManagementController::class, 'CreateStore']);