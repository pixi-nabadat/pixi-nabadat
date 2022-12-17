<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\Product;

class OrderHistoryObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\OrderHistory  $orderHistory
     * @return void
     */
    public function created(OrderHistory $orderHistory)
    {
        //when order history create update order_history_id in orders table
        Order::where('id',$orderHistory->order_id)->update(['order_history_id',$orderHistory->id]);
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\OrderHistory  $orderHistory
     * @return void
     */
    public function updated(OrderHistory $orderHistory)
    {

    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\OrderHistory  $orderHistory
     * @return void
     */
    public function deleted(OrderHistory $orderHistory)
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\OrderHistory  $orderHistory
     * @return void
     */
    public function restored(OrderHistory $orderHistory)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\OrderHistory  $orderHistory
     * @return void
     */
    public function forceDeleted(OrderHistory $orderHistory)
    {
        //
    }
}
