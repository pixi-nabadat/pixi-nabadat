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
//        'name', 'phone', 'is_active', 'location_id' ,'lat','lng','is_support_auto_service','address','description',
//        'google_map_url','avg_wating_time','featured', 'rate'
        $data =[
            'name'=>'center test','email'=>'center_test@gmail.com', 'phone'=>['01234567895'], 'is_active'=>true, 'location_id'=>7 ,'is_support_auto_service'=>true,'address'=>'test address 1','description'=>'center is perfect',
            'avg_waiting_time'=>30,'password'=>'12345678', 'support_payments'=> [PaymentMethodEnum::CASH,PaymentMethodEnum::CASH],'app_discount'=>20
        ];
       app()->make(CenterService::class)->store($data);
    }
}
