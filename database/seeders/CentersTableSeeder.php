<?php

namespace Database\Seeders;

use App\Enum\PaymentMethodEnum;
use App\Models\Address;
use App\Models\Center;
use App\Models\Device;
use App\Models\Location;
use App\Models\Product;
use App\Models\Rate;
use App\Models\User;
use App\Services\CenterService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $center_data = [
            'name'=>['ar'=>'center_test','en'=>'center test'],
            'is_support_auto_service'=>true,
            'phones'=>['01234567895'],
            'address' => [
                'ar'=>'test address',
                'en'=>'test address',
            ],
            'description' => [
                'ar'=>'center is perfect',
                'en'=>'center is perfect',
            ],
            'avg_waiting_time'=>30,
            'support_payments'=> [PaymentMethodEnum::CASH,PaymentMethodEnum::CREDIT],
            'pulse_price'=>1,
            'pulse_discount'=>0.25,
            'app_discount'=>20
        ];
        $center = Center::create($center_data) ;

        $user_data =[
            'name'=>'center test',
            'email'=>'center_test@gmail.com',
            'is_active'=>true,
            'location_id'=>7 ,
            'password'=>123456,
            'phone'=>'01113175575',
            'type'=>User::CENTERADMIN,
        ];
        $center->user()->create($user_data);
        $user = User::where('type',User::CUSTOMERTYPE)->first();
        Rate::create([
            'user_id'=>$user->id,
            'is_active'=>1,
            'comment'=>'test comment',
            'rate_number'=>3,
            'ratable_id'=>$center->id,
            'ratable_type'=>get_class($center)
        ]);
    }
}
