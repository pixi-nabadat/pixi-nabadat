<?php

namespace App\Listeners;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Events\OrderCreated;
use App\Exceptions\NotFoundException;
use App\Models\Order;
use App\Models\Package;
use App\Models\User;
use App\Models\UserPackage;
use App\Services\UserService;

class changeOrderDependencies
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(public UserService $userService)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\OrderCreated $event
     * @return void
     * @throws NotFoundException
     */
    public function handle(OrderCreated $event)
    {
        $order_id = $event->merchant_order_id;
        logger('inside event change Order Dependencies : ' . $order_id);
        if (is_null($order_id))
            throw new NotFoundException('merchant_order_id_not_found');
        $order = Order::withTrashed()->find($order_id);
        if (!$order)
            throw new NotFoundException('merchant_order_id_not_found');
        $user = User::with('nabadatWallet')->find($order->user_id);
        if (!is_null($order->relatable_id) && !is_null($order->relatable_type)) {
            $userPackage = UserPackage::withTrashed()->find($order->relatable_id);
            $userPackage->update(['deleted_at'=>null,'payment_status'=>PaymentStatusEnum::PAID]);
            $this->userService->updateOrCreateNabadatWallet($user, $userPackage);
            $order->update(['payment_status' => PaymentStatusEnum::PAID]);
        }else
             $order->update(['deleted_at' => null, 'payment_status' => PaymentStatusEnum::PAID]);
        User::setPoints($user, amount: (float)$order->grand_total);

    }
}
