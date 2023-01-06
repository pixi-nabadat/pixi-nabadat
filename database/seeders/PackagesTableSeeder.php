<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Location;
use App\Models\Package;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Package::create([
            'name'=>[
                'en'=>'vip',
                'ar'=>'vip',
            ],
            'num_nabadat'=>1000,
            'price'=>1000 ,
        ]);
    }
}
