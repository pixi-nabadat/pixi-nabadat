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
use App\Http\Controllers\Api\CancelReasonController;
use App\Http\Controllers\APi\ReservationController;

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\CouponUsageController;
use App\Http\Controllers\Api\ReservationHistoryController;

use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\CartItemController;

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\api\RatesController;
use Illuminate\Support\Facades\Auth;
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
            Route::get('cancel-reasons',[CancelReasonController::class,'listing']);
            Route::apiResource('appointments',AppointmentController::class);
        });

        Route::get('reservations', [ReservationController::class, 'listing']);
        Route::post('reservations/store',    [ReservationController::class, 'store']);
        Route::get('reservations/{id}/find', [ReservationController::class, 'find']);
        Route::post('reservations/{id}/status',  [ReservationHistoryController::class, 'store']);

        Route::post('user/coupons',       [CouponUsageController::class, 'store']);//create new coupon
        Route::post('coupon/simulation',  [CouponUsageController::class, 'simulation']);//create new coupon


        Route::group(['prefix'=>'addresses'],function(){
            Route::get ('/',[AddressController::class,'index']);
            Route::get('{address}',[AddressController::class,'find']);
            Route::post('/',[AddressController::class,'store']);
            Route::post('setDefualt/{address}',[AddressController::class,'setDefualt']);
            Route::patch('{address}',[AddressController::class,'update']);
            Route::delete('{address}',[AddressController::class,'destroy']);

        });

 });

//start cart
    Route::group(['prefix'=>'cart'],function (){
        Route::get('/', [CartController::class, 'index']);
        Route::post('item',  [CartController::class, 'store']);//create new cart
        Route::post('empty', [CartController::class, 'emptyCart']);
        Route::delete('items/{id}',  [CartController::class, 'deleteCartItem']);//delete an item from cart items
    });
//end cart
    Route::get('categories', [CategoryController::class, 'listing']);
    Route::get('products', [ProductController::class, 'listing']);
    Route::get('products/{id}/show', [ProductController::class, 'show']);

    Route::get('locations/governorates', [LocationController::class, 'getAllGovernorates']);
    Route::get('locations/{parent_id}', [LocationController::class, 'getLocationByParentId']);

    Route::get('centers', [CenterController::class, 'listing']);

    Route::get('packages', [PackageController::class, 'listing']);

    Route::get('doctor/{id}', [DoctorController::class, 'find']);

    Route::get('cancel-reasons',[CancelReasonController::class,'listing']);
Route::fallback(function () {
    return apiResponse(message: 'Invalid Route', code: 404);
});

use Laravel\Socialite\Facades\Socialite;
 
Route::get('/auth/redirect', function () {
    return Socialite::driver('facebook')->stateless()->redirect();
});

Route::get('/auth/callback', function () {
    $socialUser = Socialite::driver('facebook')->stateless()->user();
    $user = App\Models\User::firstOrCreate([
        'email' => $socialUser->email,
    ], [
        'name' => $socialUser->getName(),
        'email' => $socialUser->getEmail(),
        'username' => $socialUser->getName(),
        'password' => bcrypt($socialUser->getEmail()),
        'phone'=>$socialUser->getId(),
        'type'=> 1,
        'is_active'=>true,

    ]);
    Auth::login($user);
    return $data = [
        'token'=>$user->getToken(),
        'token_type'=>'Bearer',
        'user'=>$user
    ];
});

// start rates

    Route::post('estimation', [RatesController::class, 'store']);

// end rates
