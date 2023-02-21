<?php

namespace Database\Seeders;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('type', User::CUSTOMERTYPE)->first();
        $order =Order::create(
            [
                'user_id' => $user->id, 'payment_status' => PaymentStatusEnum::PAID, 'payment_method' => PaymentMethodEnum::CASH, 'address_info' => "{'id':'1','user_id':'2','user_name':'eslam'}",
                'address_id' => 1, 'shipping_fees' => 0, 'sub_total' => 200, 'grand_total' => 200,
                'coupon_discount' => 0
            ]
        );
        OrderItem::create(['order_id'=>$order->id,'product_id'=>1,'quantity'=>2,'price'=>100,'discount'=>20]);
        OrderHistory::create(['order_id'=>$order->id,'status'=>Order::PENDING]);
    }
}
