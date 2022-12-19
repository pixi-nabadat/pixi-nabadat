<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Payments\PaymobProvider;
use App\QueryFilters\OrdersFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class OrderService extends BaseService
{

    public function getAll(array $where_condition = [],array $withRelations = [])
    {
        $orders = $this->queryGet($where_condition,$withRelations);
        return $orders->get();
    }

    public function queryGet(array $where_condition = [],array $withRelations = []): Builder
    {
        $orders = Order::query()->with($withRelations);
        return $orders->filter(new OrdersFilter($where_condition));
    }

    public function find(int $id,$with_relation=[])
    {
        return Order::with($with_relation)->find($id);
    }

    /*
     * @param Cart $order_data
     * @param Address $shipping_address
     * @param string $payment_status
     * @param string $payment_type
     * @return mixed
     */
    public function store($user , $order_data,$shipping_address,$payment_status = 'unpaid' , $payment_type =Order::PAYMENTCASH )
    {
        $order = Order::create([
            'user_id'           => $user->id,
            'payment_status'    => $payment_status,
            'payment_type'      => $payment_type,
            'address_info'      => $shipping_address->toJson(),
            'shipping_fees'     => $shipping_address->shipping_cost ?? 0,
            'sub_total'         => $order_data->sub_total,
            'grand_total'       => $order_data->grand_total,
            'coupon_discount'   => $order_data->discount,
        ]);

          $this->setOrderItems($order, $order_data);
          $this->createOrderHistory($order);
          return $order->load('items.product','history');
    }

    private function setOrderItems(Order $order,$order_items): void
    {
        $order_items = $order_items->items->toArray();
        $order->items()->createMany($order_items);
    }

    private function createOrderHistory(Order $order): void
    {
        $order->history()->create([
            'status' => Order::PENDING,
        ]);
    }
}
