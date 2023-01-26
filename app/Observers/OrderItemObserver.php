<?php

namespace App\Observers;

use App\Enum\PaymentStatusEnum;
use App\Models\User;
use App\Models\OrderItem;
use Carbon\Carbon;
class OrderItemObserver
{
     /**
     * Handle the OrderItem "created" event.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return void
     */
    public function created(OrderItem $orderItem)
    {
        //update product stuck after adding order item
        $product = $orderItem->product;
        $product->stock = $product->stock - $orderItem->quantity;
        $product->save();
        $product->refresh();
    }

    /**
     * Handle the OrderItem "updated" event.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return void
     */
    public function updated(OrderItem $orderItem)
    {
        //
    }

    /**
     * Handle the OrderItem "deleted" event.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return void
     */
    public function deleted(OrderItem $orderItem)
    {
        //
    }

    /**
     * Handle the OrderItem "restored" event.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return void
     */
    public function restored(OrderItem $orderItem)
    {
        //
    }

    /**
     * Handle the OrderItem "force deleted" event.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return void
     */
    public function forceDeleted(OrderItem $orderItem)
    {
        //
    }
}
