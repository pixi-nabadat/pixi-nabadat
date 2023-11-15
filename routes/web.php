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
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserPackageController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ScheduleFcmController;
use App\Http\Controllers\FcmMessageController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\NabadatHistoryController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ReservationHistoryController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

//Language Change
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
// Route::get('/', function(){
//     return view('dashboard.landingPage.index');
// })->name('landingPage.index');
// Route::get('/features', function(){
//     return view('dashboard.landingPage.features');
// })->name('landingPage.features');
// Route::get('/testimonials', function(){
//     return view('dashboard.landingPage.testimonials');
// })->name('landingPage.testimonials');
// Route::get('/blog', function(){
//     return view('dashboard.landingPage.blog');
// })->name('landingPage.blog');
// Route::get('/contact', function(){
//     return view('dashboard.landingPage.contact');
// })->name('landingPage.contact');
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {

    //start user profile
    Route::get('/profile',   [AuthController::class, 'getProfile'])->name('get_profile');
    Route::patch('/profile/{user}', [AuthController::class, 'updateProfile'])->name('update_profile');
    Route::patch('update-logo', [AuthController::class, 'updateLogo'])->name('update_logo');

    //end user profile
//    change localization
    Route::get('lang/{locale}',LocalizationController::class)->name('lang');

    Route::get('logout',[AuthController::class,'logout'])->name('auth.logout');
    // Start Settings
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings');
        Route::get('general', [SettingController::class, 'appSettingsIndex'])->name('general.settings');
        Route::post('general', [SettingController::class, 'store'])->name('settings.store.general');
        Route::get('points', [SettingController::class, 'pointsSettingsIndex'])->name('points.settings');
        Route::post('points', [SettingController::class, 'store'])->name('settings.store.points');
        Route::get('social_media', [SettingController::class, 'socialMediaSettingsIndex'])->name('social_media.settings');
        Route::post('social_media', [SettingController::class, 'store'])->name('settings.store.social_media');
        Route::get('terms_and_conditions', [SettingController::class, 'termsAndConditionsSettingsIndex'])->name('terms_and_conditions.settings');
        Route::post('terms_and_conditions', [SettingController::class, 'store'])->name('settings.store.terms_and_conditions');
        Route::get('schedule_fcm', [SettingController::class, 'scheduleFcmSettingsIndex'])->name('schedule_fcm.settings');
        Route::post('schedule_fcm', [SettingController::class, 'store'])->name('settings.store.schedule_fcm');

    });
    // End Settings

    // start rates
    Route::get('/rates', [RateController::class, 'index'])->name('rates.index');
    Route::get('/rates/{id}', [RateController::class, 'show'])->name('rates.show');
    Route::delete('/rates/{id}', [RateController::class, 'destroy'])->name('rates.destroy');
    Route::post('rates/changeStatus', [RateController::class, 'status'])->name('rates.changeStatus');
    // end rates
    //start reservations
    Route::resource('reservations', ReservationController::class);
    Route::post('reservation/history/{id}', [ReservationHistoryController::class, 'store'])->name('reservation-history.store');
    Route::post('reservation/devices', [NabadatHistoryController::class, 'store'])->name('reservation-devices.store');
    //end reservations

    //start employees
    Route::resource('employees', EmployeeController::class);
    Route::post('employees/status', [EmployeeController::class, 'status'])->name('employees.status');
    //end employees

    Route::group(['prefix' => 'ajax'], function () {
        Route::get('locations/{parent_id}', [LocationController::class, 'getLocationByParentId']);
    });

    Route::get('/', HomeController::class)->name('home');
    Route::post('doctors/changeStatus', [DoctorController::class, 'status'])->name('doctors.changeStatus');

    Route::resource('governorate', GovernorateController::class);
    Route::resource('country', CountryController::class);
    Route::resource('city', CityController::class);

    Route::resource('centers', CenterController::class);
    Route::group(['prefix' => 'centers'],function (){
        Route::post('changeStatus', [CenterController::class, 'changeStatus'])->name('centers.changeStatus');
        Route::post('featured', [CenterController::class, 'featured'])->name('centers.featured');
        Route::post('support-service/changeStatus', [CenterController::class, 'changeStatusOfSupportAutoService'])->name('centers.support-auto-service.changeStatus');
    });

    #attachment routes
    Route::resource('doctors', DoctorController::class);

    Route::resource('devices', DeviceController::class);
    Route::post('devices/changeStatus', [DeviceController::class, 'changeStatus'])->name('devices.changeStatus');

    Route::resource('clients', ClientController::class);
    Route::post('clients/status', [ClientController::class, 'status'])->name('clients.status');

    Route::delete('attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachment.destroy');

    Route::resource('categories', CategoryController::class);
    Route::post('categories/changeStatus', [CategoryController::class, 'changeStatus'])->name('categories.changeStatus');

    Route::resource('coupons', CouponController::class);
    Route::post('coupons/status', [CouponController::class, 'status'])->name('coupons.status');

    Route::resource('products', ProductController::class);
    Route::post('products/featured', [ProductController::class, 'featured'])->name('products.featured');
    Route::post('products/status', [ProductController::class, 'status'])->name('products.status');

    Route::resource('packages', PackageController::class);
    Route::post('packages/status', [PackageController::class, 'status'])->name('packages.status');

    Route::resource('user-packages', UserPackageController::class);
    
    Route::resource('sliders', SliderController::class);
    Route::post('sliders/status', [SliderController::class, 'status'])->name('sliders.status');

    Route::resource('cancelReasons', CancelReasonController::class);
    Route::post('cancelReasons/changeStatus', [CancelReasonController::class, 'changeStatus'])->name('cancelReasons.changeStatus');

    Route::get('gevernorate/all', [App\Http\Controllers\GovernorateController::class, 'getAllGovernorates'])->name('allGovernorates');

    Route::post('orders/updateOrderStatus', [OrderController::class, 'updateOrderStatus'])->name('orders.updateOrderStatus');
    Route::resource('orders', OrderController::class);
    Route::post('orders/payment-status', [OrderController::class, 'paymentStatus'])->name('orders.paymentStatus');


    Route::resource('invoices', InvoiceController::class);
    Route::post('invoices/settle', [InvoiceController::class, 'settleInvoice'])->name('invoices.settle');
    Route::get('invoices/export-pdf/{id}', [InvoiceController::class, 'export'])->name('invoices.export-pdf');
    Route::get('invoices/{id}/print', [InvoiceController::class, 'print'])->name('invoices.print');


//fcm routes
Route::resource('schedule-fcm',ScheduleFcmController::class)->except('create');
Route::resource('fcm-messages',FcmMessageController::class);
Route::post('fcm-messages/status', [FcmMessageController::class, 'status'])->name('fcm-messages.status');
Route::post('schedule-fcm/status', [ScheduleFcmController::class, 'status'])->name('schedule-fcm.status');
});

Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');
Route::get('/migrate-fresh/{password}', function ($password) {
    if ($password == 150024){
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed');
        return "migrate fresh success";
    }
})->name('clear.cache');

