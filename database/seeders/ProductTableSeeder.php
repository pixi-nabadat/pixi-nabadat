<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($start = 0; $start < 10; $start++) {
           Product::create([
                'name'=>["en"=>"test$start","ar"=>"test$start"],
                'added_by'=>User::first()->id,
                'description'=>Str::random(20),
                'category_id'=>Category::all()->random()->id,
                'stock'=>100 ,
                'unit_price'=>100 ,
                'purchase_price'=>100 ,
            ]);
        }
    }
}
