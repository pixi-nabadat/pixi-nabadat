<?php

namespace Database\Seeders;

use App\Enum\ActivationStatusEnum;
use App\Models\Product;
use App\Models\Rate;
use App\Models\User;
use App\Services\RatesService;
use Illuminate\Database\Seeder;

class RateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0 ;$i<20 ;$i++)
        {

            app()->make(RatesService::class)->store([
                'user_id' => User::where('type', User::CUSTOMERTYPE)->first()->id,
                'ratable_id' => Product::first()->id,
                'ratable_type' => 1,
                'status' => ActivationStatusEnum::ACTIVE,
                'comment' => 'test',
                'rate_number' => 4]);
        }

    }
}
