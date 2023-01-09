<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CancelReasonController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\CenterDeviceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\OrderController;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\CenterDeviceController;
use App\Http\Controllers\SettingController;

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
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'index'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::get('sign-up', [AuthController::class, 'registerForm'])->name('sign-up');
        Route::post('sign-up', [AuthController::class, 'register'])->name('sign-up');
    });

    Route::view('forget-password', 'authentication.forget-password')->name('forget-password');
    Route::view('reset-password', 'authentication.reset-password')->name('reset-password');
    Route::view('maintenance', 'authentication.maintenance')->name('maintenance');
});

Route::get('/', HomeController::class)->name('/')->middleware('auth');
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {

    // Start Settings
    Route::get('/settings',          [SettingController::class,'index'])->name('settings');
    Route::get('/settings/general',      [SettingController::class,'appSettingsIndex'])->name('general.settings');
    Route::post('/settings/general', [SettingController::class,'store'])->name('settings.store.general');
    Route::get('/settings/points',   [SettingController::class,'pointsSettingsIndex'])->name('points.settings');
    Route::post('/settings/points',  [SettingController::class,'store'])->name('settings.store.points');
    Route::get('/settings/social_media',   [SettingController::class,'socialMediaSettingsIndex'])->name('social_media.settings');
    Route::post('/settings/social_media',  [SettingController::class,'store'])->name('settings.store.social_media');
    Route::get('/settings/terms_and_conditions',   [SettingController::class,'termsAndConditionsSettingsIndex'])->name('terms_and_conditions.settings');
    Route::post('/settings/terms_and_conditions',  [SettingController::class,'store'])->name('settings.store.terms_and_conditions');

    // End Settings

    Route::group(['prefix' => 'ajax'], function () {
        Route::get('locations/{parent_id}', [LocationController::class, 'getLocationByParentId']);
    });

    Route::get('/', HomeController::class)->name('home');
    Route::get('doctors/changeStatus/{doctor}', [DoctorController::class, 'changeStatus'])->name('doctors.changeStatus');
    Route::get('doctors/getAllCities/{doctor}', [DoctorController::class, 'getAllCities'])->name('doctors.getAllCities');

    Route::resource('governorate', GovernorateController::class);
    Route::resource('country', CountryController::class);
    Route::resource('city', CityController::class);

    Route::resource('centers', CenterController::class);
    Route::post('centers/changeStatus', [CenterController::class, 'changeStatus'])->name('centers.changeStatus');
    Route::post('centers/featured', [CenterController::class, 'featured'])->name('centers.featured');
    Route::post('centers/support-service/changeStatus', [CenterController::class, 'changeStatusOfSupportAutoService'])->name('centers.support-auto-service.changeStatus');

    #attachment routes
    Route::resource('doctors', DoctorController::class);

    Route::resource('devices', DeviceController::class);
    Route::post('devices/changeStatus', [DeviceController::class, 'changeStatus'])->name('devices.changeStatus');

    Route::resource('clients', ClientController::class);

    Route::delete('attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachment.destroy');

    Route::resource('categories', CategoryController::class);
    Route::post('categories/changeStatus', [CategoryController::class, 'changeStatus'])->name('categories.changeStatus');

    Route::resource('coupons', CouponController::class);
    Route::post('coupons/status', [CategoryController::class, 'status'])->name('coupons.status');

    Route::resource('products', ProductController::class);
    Route::post('products/featured', [ProductController::class, 'featured'])->name('products.featured');
    Route::post('products/status', [ProductController::class, 'status'])->name('products.status');

    Route::resource('packages', PackageController::class);
    Route::post('packages/status', [PackageController::class, 'status'])->name('packages.status');

    Route::resource('cancelReasons', CancelReasonController::class);
    Route::post('cancelReasons/changeStatus', [CancelReasonController::class, 'changeStatus'])->name('cancelReasons.changeStatus');

    Route::get('gevernorate/all', [App\Http\Controllers\GovernorateController::class, 'getAllGovernorates'])->name('allGovernorates');

    Route::resource('centerDevices', CenterDeviceController::class);

    Route::post('orders/updateOrderStatus',[OrderController::class,'updateOrderStatus'])->name('orders.updateOrderStatus');
    Route::resource('orders',OrderController::class);


});

Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');
