<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Center;
use App\Models\CenterDevice;
use App\Models\Device;
use App\Models\Location;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CenterDevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       CenterDevice::create([
           'center_id'=>Center::first()->id,
           'device_id'=>Device::first()->id,
           'regular_price'=>5,
           'nabadat_app_price'=>3,
           'auto_service_price'=>3.5,
           'number_of_devices'=>3
        ]);
    }
}
