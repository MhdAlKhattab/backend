<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfoController;

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

// For Test
Route::get('/test-online', function () {
    return 1;
});

// Auth
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::group(['middleware' => 'auth:api'], function(){
    
    // Auth
    Route::post('/change-password',[AuthController::class,'changePassword']);
    Route::get('/logout',[AuthController::class,'logout']);

    // Info
    Route::get('/info',[InfoController::class,'index']);
});


