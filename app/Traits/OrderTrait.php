<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\User;
use App\Services\AddressService;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;

trait OrderTrait
{

    public function storeOrder(Request $request, User $user)
    {
        //1- get cart data for user
        $orderData = app()->make(CartService::class)->getCart($request->serial_number);
        //2-get address info
        $userAddress = app()->make(AddressService::class)->find(id: $request->address_id, withRelations: ['city:id,title', 'user:id,name,phone,email']);
        if (!$userAddress)
            return (object)['data' => null, 'message' => trans('lang.no_address'), 'status_code' => 422];
//    check availability stocks of products
        foreach ($orderData->items as $item) {
            if ($item->quantity > $item->product->stock)
                return (object)['data' => null, 'message' => trans('lang.quantity_is_more_stock :product', ['product' => $item->product->name]), 'status_code' => 422];
        }
        $payment_type = $request->payment_type == Order::PAYMENTCREDIT ? Order::PAYMENTCREDIT : Order::PAYMENTCASH;
        $deleted_at = $payment_type == Order::PAYMENTCREDIT ? true : null;
        $order = app()->make(OrderService::class)->store(user: $user, order_data: $orderData, shipping_address: $userAddress, payment_type: $payment_type, deleted_at: $deleted_at);
        return (object)[
            'order' => $order,
            'userAddress' => $userAddress,
            'code' => 200
        ];
    }

    public function setUserOfferAsOrder(User $user, array $order_data, array $items)
    {
        $order = $user->orders()->create($order_data);
        $order->items()->create($items);
        return $order->load('items');
    }

}
