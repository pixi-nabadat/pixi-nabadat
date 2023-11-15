<?php

namespace App\Traits;

use App\Enum\PaymentMethodEnum;
use App\Exceptions\BadRequestHttpException;
use App\Exceptions\NotFoundException;
use App\Models\Order;
use App\Models\User;
use App\Services\AddressService;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;

trait OrderTrait
{

    /**
     * @throws NotFoundException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function storeOrder($orderData,$userAddress, User $user,$payment_type, bool $include_points)
    {

//    check availability stocks of products
        foreach ($orderData->items as $item) {
            if ($item->quantity > $item->product->stock)
               throw new NotFoundException(trans('lang.quantity_is_more_stock :product', ['product' => $item->product->name]));
        }
        // $deleted_at = $payment_type == PaymentMethodEnum::CREDIT ? true : null;
        return app()->make(OrderService::class)->store(user: $user, order_data: $orderData, shipping_address: $userAddress, payment_type: $payment_type, include_points: $include_points);
    }

    public function setUserOfferAsOrder(User $user, array $order_data, array $items): \Illuminate\Database\Eloquent\Model
    {
        $order = $user->orders()->create($order_data);
        $order->items()->create($items);
        $order_history = [
            'order_id'=>$order->id,
            'status'=>Order::PENDING,
        ];
        $order->history()->create($order_history);
        return $order->load('items');
    }

}
