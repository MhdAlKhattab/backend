<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\DepositController;

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
// Admin
Route::post('/super-admin',[AuthController::class,'addSuperAdmin']);

Route::group(['middleware' => 'auth:api'], function(){
    
    /////////////////////////// Auth
    Route::post('/change-password',[AuthController::class,'changePassword']);
    Route::get('/logout',[AuthController::class,'logout']);
    // Admin
    Route::post('/admin',[AuthController::class,'addAdmin']);
    Route::delete('/admin/{id}',[AuthController::class,'deleteAdmin']);


    /////////////////////////// Info
    Route::get('/info',[InfoController::class,'index']);


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
});


