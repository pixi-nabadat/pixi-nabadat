<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CenterController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PhoneVerifyController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RestPasswordController;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('phone/verify', PhoneVerifyController::class);
    Route::post('password/forget', PhoneVerifyController::class);
    Route::post('password/reset', RestPasswordController::class);
    Route::get('user', [AuthController::class, 'profile'])->middleware('auth:sanctum');
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group(['prefix' => 'centers'], function () {
        Route::post('store/doctor', [DoctorController::class, 'store']);
        Route::delete('doctors/{doctorId}', [DoctorController::class, 'delete']);
        Route::patch('doctors/{doctorId}', [DoctorController::class, 'update']);
    });
});

Route::get('categories', [CategoryController::class, 'listing']);
Route::get('products', [ProductController::class, 'listing']);
Route::get('products/{id}/show', [ProductController::class, 'show']);

Route::get('locations/governorates', [LocationController::class, 'getAllGovernorates']);
Route::get('locations/{parent_id}', [LocationController::class, 'getLocationByParentId']);

Route::get('centers', [CenterController::class, 'listing']);
Route::get('doctor/{id}', [DoctorController::class, 'find']);


Route::fallback(function () {
    return apiResponse(message: 'Invalid Route', code: 404);
});
