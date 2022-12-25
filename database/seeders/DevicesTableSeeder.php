<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Device;
use App\Models\Location;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Device::create([
           'name'=>'device test',
           'description'=>'this is test device'
        ]);
    }
}
