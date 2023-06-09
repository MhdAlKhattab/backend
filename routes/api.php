<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/////////////////////////// For Test
Route::get('/test-online', function () {
    return 1;
});

/////////////////////////// Auth
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/admin-login',[AuthController::class,'adminLogin']);
Route::post('/forget-password',[AuthController::class,'forgetPassword']);
Route::post('/reset-password',[AuthController::class,'resetPassword']);
// Admin
Route::post('/super-admin',[AuthController::class,'addSuperAdmin']);

Route::group(['middleware' => 'auth:api'], function(){
    
    /////////////////////////// Auth
    Route::post('/change-password',[AuthController::class,'changePassword']);
    Route::get('/logout',[AuthController::class,'logout']);
    // Admin
    Route::post('/admin',[AuthController::class,'addAdmin']);
    Route::delete('/admin/{id}',[AuthController::class,'deleteAdmin']);


    /////////////////////////// User
    Route::get('/get-all-users',[UserController::class,'getAllUsers']);
    Route::get('/get-normal-users',[UserController::class,'getNormalUsers']);
    Route::get('/get-admin-users',[UserController::class,'getAdminUsers']);


    /////////////////////////// Info
    Route::get('/info',[InfoController::class,'index']);


    /////////////////////////// Statistics
    Route::get('/get-statistics',[StatisticController::class,'getStatistics']);


    /////////////////////////// Deposit
    // User
    Route::get('/get-panel-deposits',[DepositController::class,'getPanelDeposits']);
    Route::get('/get-user-deposits',[DepositController::class,'getUserDeposits']);
    Route::post('/add-deposit',[DepositController::class,'store']);
    // Admin
    Route::get('/get-all-deposits',[DepositController::class,'getAllDeposits']);
    Route::get('/get-pending-deposits',[DepositController::class,'getAllPenddingDeposits']);
    Route::get('/get-complate-deposits',[DepositController::class,'getAllCompleteDeposits']);
    Route::get('/get-canceled-deposits',[DepositController::class,'getAllCanceledDeposits']);
    Route::post('/accept-deposit/{id}',[DepositController::class,'accept']);
    Route::post('/cancel-deposit/{id}',[DepositController::class,'cancel']);
    Route::delete('/delete-deposit/{id}',[DepositController::class,'destroy']);


    /////////////////////////// Withdraw
    // User
    Route::get('/get-panel-withdraws',[WithdrawController::class,'getPanelWithdraws']);
    Route::get('/get-user-withdraws',[WithdrawController::class,'getUserWithdraws']);
    Route::post('/add-withdraw',[WithdrawController::class,'store']);
    // Admin
    Route::get('/get-all-withdraws',[WithdrawController::class,'getAllWithdraws']);
    Route::get('/get-pending-withdraws',[WithdrawController::class,'getAllPenddingWithdraws']);
    Route::get('/get-complate-withdraws',[WithdrawController::class,'getAllCompleteWithdraws']);
    Route::get('/get-canceled-withdraws',[WithdrawController::class,'getAllCanceledWithdraws']);
    Route::post('/accept-withdraw/{id}',[WithdrawController::class,'accept']);
    Route::post('/cancel-withdraw/{id}',[WithdrawController::class,'cancel']);
    Route::delete('/delete-withdraw/{id}',[WithdrawController::class,'destroy']);
 
    /////////////////////////// Investment
    // User
    Route::get('/get-user-investments',[InvestmentController::class,'getUserInvestments']);
    Route::post('/add-investment',[InvestmentController::class,'store']);
    // Admin
    Route::get('/get-all-investments',[InvestmentController::class,'getAllInvestments']);
    Route::get('/get-pendding-investments',[InvestmentController::class,'getPenddingInvestments']);
    Route::get('/get-progress-investments',[InvestmentController::class,'getProgressedInvestments']);
    Route::get('/get-complete-investments',[InvestmentController::class,'getCompletedInvestments']);
    Route::get('/get-cancele-investments',[InvestmentController::class,'getCanceledInvestments']);
    Route::post('/accept-investment/{id}',[InvestmentController::class,'accept']);
    Route::post('/cancel-investment/{id}',[InvestmentController::class,'cancel']);
    Route::delete('/delete-investment/{id}',[InvestmentController::class,'destroy']);

    /////////////////////////// Referrals
    // User
    Route::get('/get-user-referrals',[ReferralController::class,'getUserReferrals']);
    Route::get('/get-user-benfit-referrals',[ReferralController::class,'getUserBenfitReferrals']);
    // Admin
    Route::get('/get-all-referrals',[ReferralController::class,'getAllReferrals']);

    /////////////////////////// Setting
    // Admin
    Route::post('/deposit-on',[SettingController::class,'depositTurnOn']);
    Route::post('/deposit-off',[SettingController::class,'depositTurnOff']);
    Route::post('/withdraw-on',[SettingController::class,'withdrawTurnOn']);
    Route::post('/withdraw-off',[SettingController::class,'withdrawTurnOff']);
    Route::post('/invest-on',[SettingController::class,'investTurnOn']);
    Route::post('/invest-off',[SettingController::class,'investTurnOff']);
    Route::get('/get-deposit-state',[SettingController::class,'getDepositState']);
    Route::get('/get-withdraw-state',[SettingController::class,'getWithdrawState']);
    Route::get('/get-invest-state',[SettingController::class,'getInvestState']);

});


