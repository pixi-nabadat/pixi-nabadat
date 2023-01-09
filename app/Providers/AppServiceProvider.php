<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Str ;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $setting = Cache::remember('dashboard_settings',60*60*24,function (){
            return  Setting::all(['name', 'val']);
        });

        config(['global' =>$setting
            ->keyBy('name') // key every setting by its name
            ->transform(function ($setting) {
                return $setting->val; // return only the value
            })
            ->toArray() // make it an array
        ]);//
    }
}
