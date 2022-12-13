<?php

namespace App\Services;

use App\Exceptions\StatusNotEquelException;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Center;
use App\QueryFilters\ReservationsFilter;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use App\Models\Order;
class OrderDeliveryService extends BaseService
{

    private static $pending   = ['pending', 'قيد الانتظار'];
    private static $confirmed = ['delivered','تم التسليم'];

   /**
    * @param array $data
    */
    public function payCash(array $data = [])
    {
        $user = Auth::user();
        $cart = $user->cart;
        $address = Address::find($data['address_id']);
        if($cart != null)
        {
            $order = new Order([
                'payment_status'   => false,
                'payment_type'     => 'cash',
                'shipping_address' => $address,
                'shipping_fees'    => $cart->shipping_cost,
                'sub_total'        => $cart->sub_total,
                'grand_total'      => $cart->grand_total,
                'coupon_discount'  => $cart->discount,
            ]);
            $user->orders()->save($order);
            $detailsStatus = $this->setOrderDetails($order, $cart);
            if($detailsStatus)
                $historyStatus = $this->orderHistory($order);
            if($historyStatus)
                return $order;
                
        }else{
            return false;
        }
        
    }

    private function setOrderDetails(Order $order, $cart){
        $cartItems = $cart->items->toArray();
        $order->details()->createMany($cartItems);
        
        $cart->delete();
        return true;
    }

    private function orderHistory(Order $order)
    {
        $order->history()->create([
            'status'      => 1,//OrderDeliveryService::$pending[0],
            'comment'     => 'coming from where',
            'notify_user' => $order->user_id
        ]);
        return true;
    }

    //pay order useing credit card
    public function payCredit(){

    }

    
}
