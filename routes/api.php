<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PhoneVerifyController;
use App\Http\Controllers\Api\RestPasswordController;
use App\Http\Controllers\Api\CenterController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\AttachmentController;

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
    Route::post('centers/all/{location_id?}', [CenterController::class, 'getAllLocationCenters']);
    Route::post('get/all/doctors', [DoctorController::class, 'getAllDoctors']);
    Route::post('store/doctor', [DoctorController::class, 'storeDoctor']);
    Route::get('find/doctor/{doctorId}', [DoctorController::class, 'findDoctor']);
    Route::delete('delete/doctor/{doctorId}', [DoctorController::class, 'deleteDoctor']);
    Route::Patch('update/doctor/{doctorId}', [DoctorController::class, 'editDoctor']);
    Route::post('get/all/centers', [CenterController::class, 'getAllCenters']);


    Route::post('file/upload', [AttachmentController::class, 'upload']);



});

Route::fallback(function() {
    return apiResponse(message:'Invalid Route',code: 404 );
});
