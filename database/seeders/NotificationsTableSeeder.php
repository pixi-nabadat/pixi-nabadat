<?php

namespace Database\Seeders;

use App\Enum\NotificationTypeEnum;
use App\Models\Address;
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

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order = Order::first();
        $notification_data =  [
            'model_id' => $order->id,
            'title' => [
                'ar' => 'test',
                'en' => 'test',
            ],
            'message' => [
                'ar' => 'test',
                'en' => 'test',
            ],
            'type' => NotificationTypeEnum::ORDER
        ];
        notifyUser($order->user , $notification_data);
    }
}
