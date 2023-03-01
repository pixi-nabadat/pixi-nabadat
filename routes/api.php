<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BuyCustomPulsesController;
use App\Http\Controllers\Api\BuyOfferController;
use App\Http\Controllers\Api\CancelReasonController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CenterController;
use App\Http\Controllers\Api\CenterDeviceController;
use App\Http\Controllers\Api\CenterPackageController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\FinanceController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PhoneVerifyController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RatesController;
use App\Http\Controllers\Api\RestPasswordController;
use App\Http\Controllers\Api\SliderController;
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
    Route::post('user/set-fcm-token', [AuthController::class, 'setFcmToken'])->middleware('auth:sanctum');
    Route::get('user', [AuthController::class, 'profile'])->middleware('auth:sanctum');

});

//for test fcm
Route::group(['prefix' => 'fcm'], function () {
    Route::post('send-to-tokens', [\App\Http\Controllers\Api\NotificationController::class, 'sendFcmToToken']);
});
Route::group(['middleware' => 'auth:sanctum'], function () {

    //start finance
    Route::get('/all-center-dues/{id}',          [FinanceController::class, 'getAllCenterDues']);
    Route::get('/all-center-dues-history/{id}',  [FinanceController::class, 'getAllCenterDuesHistory']);
    Route::get('/all-invoice-transactions/{id}', [FinanceController::class, 'getInvoiceTransactions']);
    Route::get('/transaction-details/{id}',     [FinanceController::class, 'getTransactionDetails']);
    //end finance
    Route::group(['prefix' => 'centers'], function () {
        Route::post('store/doctor', [DoctorController::class, 'store']);
        Route::delete('doctors/{doctorId}', [DoctorController::class, 'delete']);
        Route::patch('doctors/{doctorId}', [DoctorController::class, 'update']);
        Route::get('cancel-reasons', [CancelReasonController::class, 'listing']);
        Route::apiResource('appointments', AppointmentController::class);
        Route::post('/buy-pulses', [BuyCustomPulsesController::class, 'buyCustomPulses']);
    });

//start notifications routes
    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', [NotificationController::class, 'getNotifications']);
        Route::post('/mark-as-read', [NotificationController::class, 'markAsRead']);
    });

    Route::group(['prefix' => 'reservations'], function () {
        Route::get('center', [\App\Http\Controllers\Api\ReservationsController::class, 'centerReservations']);
        Route::get('customer', [\App\Http\Controllers\Api\ReservationsController::class, 'patientReservations']);
        Route::post('customer', [\App\Http\Controllers\Api\ReservationsController::class, 'store']);
        Route::get('{id}',  [\App\Http\Controllers\Api\ReservationsController::class, 'find']);
        Route::get('qrcode/{qrcode}',[\App\Http\Controllers\Api\ReservationsController::class, 'findByQrCode']);
//        Route::post('{id}/status', [ReservationHistoryController::class, 'store']);
//        Route::post('devices', [NabadatHistoryController::class, 'store']);
    });

    //start center devices
    Route::get('/devices', [DeviceController::class, 'listing']);
    Route::group(['prefix' => 'center-devices'], function () {
        Route::get('/{id}', [CenterDeviceController::class, 'listing']);
        Route::post('/', [CenterDeviceController::class, 'store']);
        Route::delete('/{id}', [CenterDeviceController::class, 'destroy']);
        Route::patch('/{id}/auto-service', [CenterDeviceController::class, 'autoService']);
        Route::patch('/{id}/status', [CenterDeviceController::class, 'status']);

    });

    //end center devices

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
        Route::post('/buy', [BuyOfferController::class, 'buyOffer']);
    });
//start buy pulsses from nabdat app
});

//start home routes
Route::get('home', [HomeController::class, 'index']);
Route::get('home/search', [HomeController::class, 'search']);


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
//start apply coupon
Route::group(['prefix' => 'coupon'], function () {
    Route::post('apply', [CartController::class, 'applyCoupon']);//create new coupon
});
//end apply coupon
Route::get('categories', [CategoryController::class, 'listing']);
Route::get('products', [ProductController::class, 'listing']);
Route::get('products/{id}/show', [ProductController::class, 'show']);

Route::get('locations/governorates', [LocationController::class, 'getAllGovernorates']);
Route::get('locations/{parent_id}', [LocationController::class, 'getLocationByParentId']);

Route::resource('centers', CenterController::class);
Route::get('centers/{id}/reservation-appointments', [AppointmentController::class, 'getReservationAppointmentsForCenter'])->name('api.center-reservation.appointments');

Route::get('week-days', [AppointmentController::class, 'getWeekDays']); // all reservations for center

//start user packages
Route::get('userPackages/listing', [UserPackageController::class, 'userPackagesListing']);
Route::get('centerPackages/listing', [UserPackageController::class, 'centerPackagesListing']);
Route::resource('userPackages', CenterController::class)->except(['index', 'store']);
//end user packages

//start slider
Route::get('sliders', [SliderController::class, 'listing']);
//end slider

Route::apiResource('packages', CenterPackageController::class);
Route::get('doctor/{id}', [DoctorController::class, 'find']);

Route::get('cancel-reasons', [CancelReasonController::class, 'listing']);
Route::fallback(function () {
    return apiResponse(message: 'Invalid Route', code: 404);
});
