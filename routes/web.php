<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CountryController ;
use App\Http\Controllers\GovernorateController ;
use App\Http\Controllers\CityController ;
use App\Http\Controllers\DeviceController;

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

    Route::get('/',HomeController::class)->name('home');
    Route::get('doctors/changeStatus/{doctor}',[DoctorController::class,'changeStatus'])->name('doctors.changeStatus');
    Route::get('doctors/getAllCities/{doctor}',[DoctorController::class,'getAllCities'])->name('doctors.getAllCities');



    Route::resource('governorate',GovernorateController::class);
    Route::resource('country',CountryController::class);
    Route::resource('city',CityController::class);
    Route::resource('centers', CenterController::class);
    #attachment routes
    Route::resource('doctors',DoctorController::class);
    Route::resource('devices',DeviceController::class);
    Route::resource('clinics',ClinicController::class);
    Route::resource('clients',ClientController::class);

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
