<?php

namespace Database\Seeders;

use App\Models\Center;
use App\Models\Device;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DoctorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Doctor::create([
           'name'=>[
               'en'=>Str::random(),
               'ar'=>Str::random()
           ],
           'description' => [
               'en'=>Str::random(50),
               'ar'=>Str::random(50),
           ],
           'age' => 22,
           'center_id' => Center::first()->id,
           'phone' => 0111362245
        ]);
    }
}
