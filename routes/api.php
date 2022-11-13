<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PhoneVerifyController;
use App\Http\Controllers\Api\RestPasswordController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\UserPackageController;
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
Route::group(['prefix'=>'auth'],function (){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('phone/verify',  PhoneVerifyController::class);
    Route::post('password/forget',  PhoneVerifyController::class);
    Route::post('password/reset', RestPasswordController::class);
    Route::get('user',[AuthController::class,'profile'])->middleware('auth:sanctum');
});
    Route::get('categories',[CategoryController::class,'listing']);
    Route::get('products',[ProductController::class,'listing']);
    Route::get('products/{id}/show',[ProductController::class,'show']);
    Route::get('locations/governorates',[LocationController::class,'getAllGovernorates']);
    Route::get('locations/{parent_id}',[LocationController::class,'getLocationByParentId']);

    Route::get ('userPackages',[UserPackageController::class,'index']);
    Route::post('userPackages/store',[UserPackageController::class,'store']);
    Route::post('userPackages/update/{userPackage}',[UserPackageController::class,'update']);
    Route::post('userPackages/destroy/{userPackage}',[UserPackageController::class,'destroy']);


Route::fallback(function() {
    return apiResponse(message:'Invalid Route',code: 404 );
});
