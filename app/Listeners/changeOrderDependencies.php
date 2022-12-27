<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Exceptions\NotFoundException;
use App\Models\Order;
use App\Models\Package;
use App\Models\User;
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
        $user = User::with('nabadatWallet')->find($order->user_id);
        if (!$order)
            throw new NotFoundException('merchant_order_id_not_found');
        if (!is_null($order->relatable_id) && !is_null($order->relatable_type)) {
            $package = Package::find($order->relatable_id);
            $this->userService->updateOrCreateNabadatWallet($user, $package);
        }
        $order->update(['deleted_at' => null, 'payment_status' => Order::PAID]);
    }
}