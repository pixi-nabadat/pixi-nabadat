<?php

namespace Database\Seeders;

use App\Enum\ActivationStatusEnum;
use App\Enum\PackageStatusEnum;
use App\Models\Address;
use App\Models\Center;
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
      $center = Center::first();
       Package::create([
            'name'=>[
                'en'=>'vip',
                'ar'=>'vip',
            ],
            'center_id'=>$center->id,
            'num_nabadat'=>1000,
            'price'=>1000 ,
            'start_date'=>now()->format('Y-m-d') ,
            'end_date'=>now()->addDay()->format('Y-m-d') ,
            'discount_percentage'=>20 ,
            'status'=>PackageStatusEnum::APPROVED ,
            'is_active'=>ActivationStatusEnum::ACTIVE ,
        ]);
    }
}
