<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Center;
use App\Models\Coupon;
use App\Models\Device;
use App\Models\Location;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $center = Center::first();
          $slider1 =  Slider::create([
               'center_id'=>$center->id,
               'order'=>'1',
               'start_date'=>Carbon::now()->format('Y-m-d'),
               'end_date'=>Carbon::now()->addDays(5)->format('Y-m-d'),
               'duration'=>20,
               'is_active'=>true,
           ]);

        $slider2 =  Slider::create([
            'center_id'=>$center->id,
            'order'=>'1',
            'start_date'=>Carbon::now()->format('Y-m-d'),
            'end_date'=>Carbon::now()->addDays(5)->format('Y-m-d'),
            'duration'=>20,
            'is_active'=>true,
        ]);

        $slider3 =  Slider::create([
            'center_id'=>$center->id,
            'order'=>'1',
            'start_date'=>Carbon::now()->format('Y-m-d'),
            'end_date'=>Carbon::now()->addDays(5)->format('Y-m-d'),
            'duration'=>20,
            'is_active'=>true,
        ]);

    }
}
