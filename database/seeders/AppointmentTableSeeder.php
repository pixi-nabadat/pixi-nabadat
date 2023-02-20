<?php

namespace Database\Seeders;

use App\Enum\NotificationTypeEnum;
use App\Models\Address;
use App\Models\Appointment;
use App\Models\Center;
use App\Models\Coupon;
use App\Models\Device;
use App\Models\Location;
use App\Models\Order;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $center = Center::first();
        Appointment::create([
            'day_of_week'=>0,
            'day_text'=>[
                'ar'=>'الاحد',
                'en'=>'Sunday',
            ],
            'center_id'=>$center->id,
            'to'=>Carbon::now()->format("H:i:s"),
            'from'=>Carbon::now()->addHours(7)->format("H:i:s")
        ]);
        Appointment::create([
            'day_of_week'=>1,
            'day_text'=>[
                'ar'=>'الاثنين',
                'en'=>'Monday',
            ],
            'center_id'=>$center->id,
            'to'=>Carbon::now()->format("H:i:s"),
            'from'=>Carbon::now()->addHours(7)->format("H:i:s")
        ]);

    }
}
