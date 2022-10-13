<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;

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
    Route::get('/', function () {
       dd(auth()->user());
    })->name('/');
});

Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');
