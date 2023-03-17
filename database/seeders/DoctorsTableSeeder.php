<?php

namespace Database\Seeders;

use App\Models\Center;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

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
            'name' => [
                'en' => 'test doctor',
                'ar' => 'test doctor'
            ],
            'description' => [
                'en' => 'test doctor',
                'ar' => 'test doctor',
            ],
            'center_id' => Center::first()->id,
            'phone' => 0111362245
        ]);
    }
}
