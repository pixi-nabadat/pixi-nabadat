<?php

namespace App\Listeners;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
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
        $paymob_object = $event->paymobResult;
        $order_id = $paymob_object['merchant_order_id'];
        $paymob_transaction_id = $paymob_object['id'];

        logger('inside event change Order Dependencies : ' . $order_id);

        if (is_null($order_id))
            throw new NotFoundException('merchant_order_id_not_found');

        $order = Order::find($order_id);

        if (!$order)
            throw new NotFoundException('merchant_order_id_not_found');

        $user = User::with('nabadatWallet')->find($order->user_id);

        if (!is_null($order->relatable_id) && !is_null($order->relatable_type)) {
            $userPackage = UserPackage::find($order->relatable_id);
            $active_user_package = $user->package()->where('status', UserPackageStatusEnum::ONGOING)->where('payment_status', PaymentStatusEnum::PAID)->count();
            if(!$active_user_package)
                $status = UserPackageStatusEnum::ONGOING;
            else
                $status = UserPackageStatusEnum::READYFORUSE;
    
            $userPackage->update(['payment_status'=>PaymentStatusEnum::PAID, 'status'=>$status]);
            $this->userService->updateOrCreateNabadatWallet($user, $userPackage);
        }

        $order_data = [
            'payment_status' => PaymentStatusEnum::PAID,
            'paymob_transaction_id'=>$paymob_transaction_id
        ];

        $order->update($order_data);

    }
}
