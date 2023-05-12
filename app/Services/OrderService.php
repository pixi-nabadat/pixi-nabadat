<?php

namespace App\Services;

use App\Enum\NotificationTypeEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\User;
use App\QueryFilters\OrdersFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class OrderService extends BaseService
{

    public function listing($filters = [], $withRelations = [])
    {
        $perPage = config('app.perPage') ?? 10;
        return $this->queryGet($filters, $withRelations)->cursorPaginate($perPage);
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

        $pounds_for_points =  optional($order_data)->pounds_for_points ?? 0;
        $grand_total = $order_data->grand_total_after_discount-$pounds_for_points;
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
            'points_discount' =>$pounds_for_points ,
            'deleted_at' => $deleted_at
        ]);

        $this->setOrderItems($order, $order_data);
        $this->createOrderHistory($order);
        $this->updateCouponUsage($user->id, $order_data['temp_user_id'], optional($order_data->coupon)->id);
        return $order->load('items.product.defaultLogo', 'history');
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
       $order->history()->create([
            'status' => Order::PENDING,
        ]);
    }

    private function updateCouponUsage($user_id, $temp_user_id, $coupon_id = null)
    {
        if (!isset($coupon_id))
            return;
        $coupon_usage = CouponUsage::query()->where('temp_user_id', $temp_user_id)->where('coupon_id', $coupon_id)->first();
        $old_usage = optional($coupon_usage)->number_of_usage ?? 0;
        CouponUsage::query()->updateOrCreate([
            'temp_user_id' => $temp_user_id,
            'user_id' => $user_id,
            'coupon_id' => $coupon_id
        ], [
            'number_of_usage' => $old_usage + 1
        ]);
    }

    public function updateOrderStatus($data): void
    {
        $order = $this->find($data['id']);
        $order->history()->create([
            'status' => $data['status'],
        ]);

        //set user points
        if ($data['status'] == Order::DELIVERED)
            User::setPoints($order->user, amount: (float)$order->grand_total);
    }

    /**
     * @throws NotFoundException
     */
    public function find(int $id, $with_relation = [])
    {
        $order = Order::activeOrder()->with($with_relation)->find($id);
        if (!$order)
            throw new NotFoundException(trans('lang.order_not_found'));
        return $order ;
    }

    public function notifiyUser(Order $order)
    {
        return [
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
    }
}
