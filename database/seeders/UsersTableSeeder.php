<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>123456,
            'phone'=>'01113622098',
            'type'=>User::SUPERADMINTYPE,
            'last_login'=>now(),
            'date_of_birth'=>Carbon::now()->format('Y-m-d'),
            'is_active'=>User::ACTIVE,
            'location_id'=>7
        ]);
        \App\Models\User::create([
            'name'=>'customer',
            'email'=>'customer@gmail.com',
            'password'=>123456,
            'phone'=>'01022843293',
            'type'=>User::CUSTOMERTYPE,
            'last_login'=>now(),
            'date_of_birth'=>Carbon::now()->format('Y-m-d'),
            'is_active'=>User::ACTIVE,
            'location_id'=>7
        ]);
  }
}
