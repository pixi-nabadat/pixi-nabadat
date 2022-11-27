<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CountryController ;
use App\Http\Controllers\GovernorateController ;
use App\Http\Controllers\CityController ;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CancelReasonController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\PackageController;

//Language Change
Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ar'])) {
        abort(400);
    }
    Session()->put('locale', $locale);
    Session::get('locale');
    return redirect()->back();
})->name('lang');

Route::prefix('authentication')->group(function () {
    Route::middleware('guest')->group(function (){
        Route::get('login',[AuthController::class,'index'])->name('login');
        Route::post('login',[AuthController::class,'login'])->name('login');
        Route::get('sign-up', [AuthController::class,'registerForm'])->name('sign-up');
        Route::post('sign-up', [AuthController::class,'register'])->name('sign-up');
    });

    Route::view('forget-password', 'authentication.forget-password')->name('forget-password');
    Route::view('reset-password', 'authentication.reset-password')->name('reset-password');
    Route::view('maintenance', 'authentication.maintenance')->name('maintenance');
});

Route::get('/',HomeController::class)->name('/')->middleware('auth');
Route::group(['prefix'=>'dashboard','middleware'=>'auth'],function (){

    Route::group(['prefix'=>'ajax'],function (){
        Route::get('locations/{parent_id}',[LocationController::class,'getLocationByParentId']);
    });

    Route::get('/',HomeController::class)->name('home');
    Route::get('doctors/changeStatus/{doctor}',[DoctorController::class,'changeStatus'])->name('doctors.changeStatus');
    Route::get('doctors/getAllCities/{doctor}',[DoctorController::class,'getAllCities'])->name('doctors.getAllCities');

    Route::resource('governorate',GovernorateController::class);
    Route::resource('country',CountryController::class);
    Route::resource('city',CityController::class);

    Route::resource('centers', CenterController::class);
    Route::post('centers/changeStatus',[CenterController::class,'changeStatus'])->name('centers.changeStatus');
    Route::post('centers/support-service/changeStatus',[CenterController::class,'changeStatusOfSupportAutoService'])->name('centers.support-auto-service.changeStatus');

    #attachment routes
    Route::resource('doctors',DoctorController::class);

    Route::resource('devices',DeviceController::class);
    Route::post('devices/changeStatus',[DeviceController::class,'changeStatus'])->name('devices.changeStatus');

    Route::resource('clients',ClientController::class);

    Route::delete('attachments/{attachment}',[AttachmentController::class,'destroy'])->name('attachment.destroy');

    Route::resource('categories',CategoryController::class);
    Route::post('categories/changeStatus',[CategoryController::class,'changeStatus'])->name('categories.changeStatus');
  
    Route::resource('coupons',CouponController::class);
    Route::post('coupons/status',[CategoryController::class,'status'])->name('coupons.status');

    Route::resource('products',ProductController::class);
    Route::post('products/featured',[ProductController::class,'featured'])->name('products.featured');
    Route::post('products/status',[ProductController::class,'status'])->name('products.status');

    Route::resource('packages',PackageController::class);
    Route::post('packages/status',[PackageController::class,'status'])->name('packages.status');

    Route::resource('cancelReasons',CancelReasonController::class);
    Route::post('cancelReasons/changeStatus',[CancelReasonController::class,'changeStatus'])->name('cancelReasons.changeStatus');

    Route::get('gevernorate/all', [App\Http\Controllers\GovernorateController::class, 'getAllGovernorates'])->name('allGovernorates');
});

Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');
