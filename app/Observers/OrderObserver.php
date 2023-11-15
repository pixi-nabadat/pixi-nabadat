<?php

namespace App\Observers;

use App\Enum\PaymentStatusEnum;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param \App\Models\Order $order
     * @return void
     */
    public function created(Order $order)
    {
        //set the user points after making order
        if(is_null($order->retable_type) && $order->payment_status == PaymentStatusEnum::PAID)
        {
            $user = User::find($order->user_id);
            User::setPoints(model: $user, amount: $order->grand_total);
        }
    }

    /**
     * Handle the Order "updating" event.
     *
     * @param \App\Models\Order $order
     * @return void
     */
    public function updating(Order $order)
    {
        if($order->isDirty('payment_status'))
        {
            //set the user points after making order
            if(is_null($order->retable_type) && $order->payment_status == PaymentStatusEnum::PAID)
            {
                $user = User::find($order->user_id);
                User::setPoints(model: $user, amount: $order->grand_total);
            }

        }
    }
    /**
     * Handle the Order "updated" event.
     *
     * @param \App\Models\Order $order
     * @return void
     */
    public function updated(Order $order)
    {
//        ToDo when user package update payment status to paid
//       ToDo update nabadat user wallet
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param \App\Models\Order $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param \App\Models\Order $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param \App\Models\Order $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
