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
use Illuminate\Support\Facades\Http;
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
            'status_en' => OrderDeliveryService::$pending[0],
            'status_ar' => OrderDeliveryService::$pending[1],
        ]);
        return true;
    }

    //pay order useing credit card
    public function payCredit(){
        $user = Auth::user();
        $cart = $user->cart;
        $address = Address::find($data['address_id']);
        $paymentStatus = $this->payPaymob();
        if($paymentStatus){
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
        
    }

    public function payPaymob()//: \Illuminate\Http\Client\Response
    {
        $authToken             = $this->authRequest();  
        $orderRegisterationAPi = $this->orderRegisterationAPi(token: $authToken);
        $response              = $this->paymentKeyRequest(token: $authToken, orderId: $orderRegisterationAPi['orderId']);
        return redirect()->away("https://accept.paymob.com/api/acceptance/iframes/447816?payment_token=".$response);
    }

    private function authRequest()
    {
        $response = Http::withHeaders([
            "Accept"=>"application/json",
            "Content-Type"=>"application/json"
        ])->withBody(
            '{"api_key": "ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SndjbTltYVd4bFgzQnJJam96TURNd01Ua3NJbTVoYldVaU9pSXhOamN3T1RZek1UQTJMakUyTkRFM09TSXNJbU5zWVhOeklqb2lUV1Z5WTJoaGJuUWlmUS45UEdBNWZZakc3bWdEbkVuZVZmNnE4U2JfY3NReTl4UTI4c0VERmg4RDhjanFFT0Y4aFg4MG5PdVhuOUFlNWFFRDFsYzMtNXVFNUZ1c1RXSklPcTNlUQ=="}',"application/json"
        )->post('https://accept.paymob.com/api/auth/tokens');
        return $response['token'];
    }

    private function orderRegisterationAPi(string $token)
    {
        $response = Http::withHeaders([
            "Accept"=>"application/json",
            "Content-Type"=>"application/json"
        ])->withBody(
            '{
                "auth_token":  "'.$token.'",
                "delivery_needed": "false",
                "amount_cents": "100",
                "currency": "EGP",
                "merchant_order_id": 47,
                "items": [
                  {
                      "name": "ASC1515",
                      "amount_cents": "500000",
                      "description": "Smart Watch",
                      "quantity": "1"
                  },
                  { 
                      "name": "ERT6565",
                      "amount_cents": "200000",
                      "description": "Power Bank",
                      "quantity": "1"
                  }
                  ],
                "shipping_data": {
                  "apartment": "803", 
                  "email": "claudette09@exa.com", 
                  "floor": "42", 
                  "first_name": "Clifford", 
                  "street": "Ethan Land", 
                  "building": "8028", 
                  "phone_number": "+86(8)9135210487", 
                  "postal_code": "01898", 
                   "extra_description": "8 Ram , 128 Giga",
                  "city": "Jaskolskiburgh", 
                  "country": "CR", 
                  "last_name": "Nicolas", 
                  "state": "Utah"
                },
                  "shipping_details": {
                      "notes" : " test",
                      "number_of_packages": 1,
                      "weight" : 1,
                      "weight_unit" : "Kilogram",
                      "length" : 1,
                      "width" :1,
                      "height" :1,
                      "contents" : "product of some sorts"
                  }
              }',"application/json"
        )->post('https://accept.paymob.com/api/ecommerce/orders');
        return ['orderId'=>$response['id'], 'token'=>$response['token'], ];
    }
    
    private function paymentKeyRequest(string $token , int $orderId)
    {
        $response = Http::withHeaders([
            "Accept"=>"application/json",
            "Content-Type"=>"application/json"
        ])->withBody(
            '{
                "auth_token": "'.$token.'",
                "amount_cents": "100", 
                "expiration": 3600, 
                "order_id": '.$orderId.',
                "billing_data": {
                  "apartment": "803", 
                  "email": "claudette09@exa.com", 
                  "floor": "42", 
                  "first_name": "Clifford", 
                  "street": "Ethan Land", 
                  "building": "8028", 
                  "phone_number": "+86(8)9135210487", 
                  "shipping_method": "PKG", 
                  "postal_code": "01898", 
                  "city": "Jaskolskiburgh", 
                  "country": "CR", 
                  "last_name": "Nicolas", 
                  "state": "Utah"
                }, 
                "currency": "EGP", 
                "integration_id": 2587202,
                "lock_order_when_paid": "false"
              }',"application/json"
        )->post('https://accept.paymob.com/api/acceptance/payment_keys?&');
        return $response['token'];
    }
}
