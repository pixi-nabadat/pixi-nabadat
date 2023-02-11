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
           'is_support_auto_service'=>1,
           'is_active'=>1,
           'number_of_devices'=>3
        ]);
    }
}
