<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Location;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Address::create([
            'address'=>'test address',
            'user_id'=>User::where('type',User::CUSTOMERTYPE)->first()->id,
            'country_id'=>1 ,
            'governorate_id'=>2 ,
            'city_id'=>4 ,
            'phone'=>'01113622098' ,
            'postal_code'=>122323 ,
        ]);
    }
}
