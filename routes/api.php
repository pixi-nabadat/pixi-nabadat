<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BuyOfferController;
use App\Http\Controllers\Api\CancelReasonController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CenterController;
use App\Http\Controllers\Api\CenterPackageController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\NabadatHistoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PhoneVerifyController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\api\RatesController;
use App\Http\Controllers\APi\ReservationController;
use App\Http\Controllers\Api\ReservationHistoryController;
use App\Http\Controllers\Api\RestPasswordController;
use App\Http\Controllers\Api\UserPackageController;
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
    Route::post('user/set-fcm-token', [AuthController::class, 'setFcmToken'])->middleware( 'auth:sanctum');
    Route::get('user', [AuthController::class, 'profile'])->middleware( 'auth:sanctum');

});

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('week-days', [AppointmentController::class, 'getWeekDays']); // all reservations for center
    Route::group(['prefix' => 'centers'], function () {
        Route::post('store/doctor', [DoctorController::class, 'store']);
        Route::delete('doctors/{doctorId}', [DoctorController::class, 'delete']);
        Route::patch('doctors/{doctorId}', [DoctorController::class, 'update']);
        Route::get('cancel-reasons', [CancelReasonController::class, 'listing']);
        Route::apiResource('appointments', AppointmentController::class);
    });

    Route::group(['prefix' => 'reservations'], function () {
        Route::get('/', [ReservationController::class, 'listing']); // all reservations for center
        Route::get('/patient', [ReservationController::class, 'patientReservations']); // all reservations for patient
        Route::post('/', [ReservationController::class, 'store']);
        Route::get('{id}', [ReservationController::class, 'find']);
        Route::post('{id}/status', [ReservationHistoryController::class, 'store']);
        Route::post('devices', [NabadatHistoryController::class, 'store']);

    });
    // start rates
    Route::group(['prefix' => 'rate'], function () {
        Route::post('/', [RatesController::class, 'store']);
        Route::delete('{id}', [RatesController::class, 'destroy']);
    });
    // end rates
    // end rates

    Route::group(['prefix' => 'addresses'], function () {
        Route::get('/', [AddressController::class, 'index']);
        Route::get('{address}', [AddressController::class, 'find']);
        Route::post('/', [AddressController::class, 'store']);
        Route::post('{address}', [AddressController::class, 'update']);
        Route::post('set-default/{address}', [AddressController::class, 'setDefault']);
        Route::post('set-default/{address}', [AddressController::class, 'setDefault']);
        Route::delete('{address}', [AddressController::class, 'destroy']);
    });
    //start order delivery
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('{id}', [OrderController::class, 'find']);
        Route::post('/', [OrderController::class, 'store']);
    });
    //end order delivery
//start buy pulsses from nabdat app
    Route::group(['prefix' => 'offers'], function () {
        Route::get('/', [BuyOfferController::class, 'index']);
        Route::post('/buy', [BuyOfferController::class, 'buyOffer']);
    });
//start buy pulsses from nabdat app

    Route::group(['prefix' => 'coupon'], function () {
        Route::post('apply', [CartController::class, 'applyCoupon']);//create new coupon
    });
});

//callback form paymob getaway
Route::any('paymob/payment/done', [OrderController::class, 'checkPaymobPaymentStatus']);
//start cart
Route::group(['prefix' => 'cart'], function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('item', [CartController::class, 'store']);//create new cart
    Route::post('set-address', [CartController::class, 'updateCartAddress'])->middleware('auth:sanctum');
    Route::delete('empty', [CartController::class, 'empty']);
    Route::delete('items/{id}', [CartController::class, 'deleteCartItem']);//delete an item from cart items
});
//end cart
Route::get('categories', [CategoryController::class, 'listing']);
Route::get('products', [ProductController::class, 'listing']);
Route::get('products/{id}/show', [ProductController::class, 'show']);

Route::get('locations/governorates', [LocationController::class, 'getAllGovernorates']);
Route::get('locations/{parent_id}', [LocationController::class, 'getLocationByParentId']);

Route::get('centers', [CenterController::class, 'listing']);

Route::get('packages', [PackageController::class, 'listing']);


//start user packages
Route::get('userPackages/listing', [UserPackageController::class, 'userPackagesListing']);
Route::get('centerPackages/listing', [UserPackageController::class, 'centerPackagesListing']);
Route::resource('userPackages', CenterController::class)->except(['index', 'store']);
//end user packages
Route::get('center-offers', [CenterPackageController::class, 'listing']);
Route::resource('packages', CenterPackageController::class);
Route::get('doctor/{id}', [DoctorController::class, 'find']);

Route::get('cancel-reasons', [CancelReasonController::class, 'listing']);
Route::fallback(function () {
    return apiResponse(message: 'Invalid Route', code: 404);
});
