<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Device;
use App\Models\Location;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Coupon::create([
           'added_by'=>User::where('type',User::SUPERADMINTYPE)->first()->id,
           'code'=>'test123',
           'discount'=>10,
           'start_date'=>Carbon::now()->format('Y-m-d'),
           'end_date'=>Carbon::now()->addDays(5)->format('Y-m-d'),
           'min_buy'=>20,
           'allowed_usage'=>5,
           'coupon_for'=>Coupon::STORECOUPON
       ]);
    }
}
