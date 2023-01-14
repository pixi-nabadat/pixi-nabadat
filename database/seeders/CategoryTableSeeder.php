<?php

namespace Database\Seeders;

use App\Enum\ActivationStatusEnum;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rate;
use App\Models\User;
use App\Services\RatesService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
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

            Category::create([
                'name'=>Str::random(8)
            ]);
        }

    }
}
