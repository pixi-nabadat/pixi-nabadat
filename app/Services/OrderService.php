<?php

namespace App\Services;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\User;
use App\QueryFilters\OrdersFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class OrderService extends BaseService
{

    public function listing($filters=[],$withRelations=[])
    {
        $perPage = config('app.perPage')??10;
        return $this->queryGet($filters,$withRelations)->cursorPaginate($perPage);
    }
    
    public function getAll(array $where_condition = [], array $withRelations = [])
    {
        $orders = $this->queryGet($where_condition, $withRelations);
        return $orders->get();
    }

    public function queryGet(array $where_condition = [], array $withRelations = []): Builder
    {
        $orders = Order::activeOrder()->with($withRelations);
        return $orders->filter(new OrdersFilter($where_condition));
    }

    public function store($user, $order_data, $shipping_address, $payment_status = PaymentStatusEnum::UNPAID, $payment_type = PaymentMethodEnum::CASH, $deleted_at = null, $relatable_id = null, $relatable_type = null)
    {
        if (isset($deleted_at))
            $deleted_at = Carbon::now();
//        check if coupon is valid
        $grand_total = $order_data->grand_total_after_discount;
        $order = Order::create([
            'user_id' => $user->id,
            'payment_status' => $payment_status,
            'payment_method' => $payment_type,
            'address_id' => $shipping_address->id,
            'address_info' => $shipping_address->toJson(),
            'shipping_fees' => $shipping_address->city->shipping_cost ?? 0,
            'sub_total' => $order_data->sub_total,
            'grand_total' => $grand_total,
            'coupon_discount' => optional($order_data->coupon)->discount ?? 0,
            'deleted_at' => $deleted_at
        ]);

        $this->setOrderItems($order, $order_data);
        $this->createOrderHistory($order);
        $this->updateCouponUsage($user->id,optional( $order_data->coupon)->id);
        return $order->load('items.product', 'history');
    }

    /*
     * @param Cart $order_data
     * @param Address $shipping_address
     * @param string $payment_status
     * @param string $payment_type
     * @return mixed
     */

    private function setOrderItems(Order $order, $order_items): void
    {
        $order_items = $order_items->items->toArray();
        $order->items()->createMany($order_items);
    }

    private function createOrderHistory(Order $order): void
    {
        $order_history = $order->history()->create([
            'status' => Order::PENDING,
        ]);
        $order->update(['order_history_id' => $order_history->id]);
    }

    private function updateCouponUsage($user_id, $coupon_id=null)
    {
        if (!isset($coupon_id))
            return ;
        $coupon_usage = CouponUsage::query()->where('user_id', $user_id)->where('coupon_id', $coupon_id)->first();
        $old_usage = optional($coupon_usage)->number_of_usage ?? 0;
        CouponUsage::query()->updateOrCreate([
            'user_id' => $user_id,
            'coupon_id' => $coupon_id
        ], [
            'number_of_usage' => $old_usage + 1
        ]);
    }

    public function updateOrderStatus($data): void
    {
        $order = $this->find($data['id']);
        $order_history = $order->history()->create([
            'status' => $data['status'],
        ]);
        $order->order_history_id = $order_history->id;
        $order->save();
        $order->refresh();

        //set user points
        if ($data['status'] == Order::DELIVERED)
            User::setPoints($order->user(), amount: (float)$order->grand_total, amountType: 'cash');
    }

    public function find(int $id, $with_relation = [])
    {
        return Order::activeOrder()->with($with_relation)->find($id);
    }
}
