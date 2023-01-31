<?php

namespace Database\Seeders;

use App\Enum\PaymentMethodEnum;
use App\Models\Address;
use App\Models\Center;
use App\Models\Device;
use App\Models\Location;
use App\Models\Product;
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
            'app_discount'=>20
        ];
        $center = Center::create($center_data) ;

        $user_data =[
            'name'=>'center test',
            'email'=>'center_test@gmail.com',
            'user_name'=>"center".time(),
            'is_active'=>true,
            'location_id'=>7 ,
            'password'=>bcrypt(123456),
            'phone'=>0111362245,
            'type'=>User::CENTERADMIN,
        ];
        $center->user()->create($user_data);
    }
}
