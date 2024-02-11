<?php

namespace Database\Seeders;

use App\Models\PackageCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0 ;$i<4 ;$i++)
        {

            PackageCategory::create([
                'name'=>Str::random(8)
            ]);
        }

    }
}
