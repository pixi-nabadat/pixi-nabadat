<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
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


Route::group(['prefix'=>'dashboard','middleware'=>'auth'],function (){
    Route::get('/',HomeController::class)->name('home');
    #Country Module
    Route::GET('country/index', [App\Http\Controllers\CountryController::class,'index'])->name('list.country');
    Route::GET('country/create', [App\Http\Controllers\CountryController::class,'create'])->name('create.country');
    Route::POST('country/store', [App\Http\Controllers\CountryController::class,'store'])->name('store.country');
    Route::DELETE('country/delete/{id}', [App\Http\Controllers\CountryController::class,'delete'])->name('delete.country');
    Route::GET('country/edit/{id}', [App\Http\Controllers\CountryController::class,'edit'])->name('edit.country');
    Route::GET('country/show/{id}', [App\Http\Controllers\CountryController::class,'show'])->name('show.country');
    Route::POST('country/update/{id}', [App\Http\Controllers\CountryController::class,'update'])->name('update.country');


    #Governorate Module
    Route::GET('governorate/index', [App\Http\Controllers\GovernorateController::class,'index'])->name('list.governorate');
    Route::GET('governorate/create', [App\Http\Controllers\GovernorateController::class,'create'])->name('create.governorate');
    Route::POST('governorate/store', [App\Http\Controllers\GovernorateController::class,'store'])->name('store.governorate');
    Route::DELETE('governorate/delete/{id}', [App\Http\Controllers\GovernorateController::class,'delete'])->name('delete.governorate');
    Route::GET('governorate/edit/{id}', [App\Http\Controllers\GovernorateController::class,'edit'])->name('edit.governorate');
    Route::GET('governorate/show/{id}', [App\Http\Controllers\GovernorateController::class,'show'])->name('show.governorate');
    Route::POST('governorate/update/{id}', [App\Http\Controllers\GovernorateController::class,'update'])->name('update.governorate');


    #City Module
    Route::GET('city/index', [App\Http\Controllers\CityController::class,'index'])->name('list.city');
    Route::GET('city/create', [App\Http\Controllers\CityController::class,'create'])->name('create.city');
    Route::POST('city/store', [App\Http\Controllers\CityController::class,'store'])->name('store.city');
    Route::DELETE('city/delete/{id}', [App\Http\Controllers\CityController::class,'delete'])->name('delete.city');
    Route::GET('city/edit/{id}', [App\Http\Controllers\CityController::class,'edit'])->name('edit.city');
    Route::GET('city/show/{id}', [App\Http\Controllers\CityController::class,'show'])->name('show.city');
    Route::POST('city/update/{id}', [App\Http\Controllers\CityController::class,'update'])->name('update.city');

    #attachment routes
    Route::POST('file/upload', [App\Http\Controllers\AttachmentController::class, 'upload']);
    Route::POST('file/delete', [App\Http\Controllers\AttachmentController::class, 'delete'])->name('file.delete');

    Route::resource('doctors',DoctorController::class);
    Route::resource('clinics',ClinicController::class);
    Route::resource('clients',ClientController::class);

});

Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');



#TODO remove this

