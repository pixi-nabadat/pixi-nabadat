<?php

namespace App\Services\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class paymobService
{
    public $baseUrl = 'https://accept.paymob.com/api';
    /*
     * 1. Authentication Request:
        The Authentication request is an elementary step you should do before dealing with any of Accept's APIs.
        It is a post request with a JSON object which contains your api_key
     */
    public function getAuthToken()
    {
        $response = Http::post($this->baseUrl.'/auth/tokens',[
            "api_key"=>config('services.paymob.api_key')
        ]);

        return $response->object()->token;
    }

    /*
     * 2. Order Registration API
         At this step, you will register an order to Accept's database,
         so that you can pay for it later using a transaction.Order ID will be the identifier
         that you will use to link the transaction(s) performed to your system, as one order can have more than one transaction.
     */
    public function createOrder($items=[])
    {
        return Http::post($this->baseUrl.'/ecommerce/orders',$items);
    }


    /*
     * 3. Payment Key Request
     At this step, you will obtain a payment_key token. This key will be used to authenticate your payment request.
     It will be also used for verifying your transaction request metadata.
     */
    public function getPaymentToken($order_id, $token,$total_amount_cents, $shippingAddress): \Illuminate\Http\Client\Response
    {
        //  All the fields in this object are mandatory, you can send any of these information
        // if it isn't available, please send it to be "NA", except, first_name,
        // last_name, email, and phone_number cannot be sent as "NA".
        $billingData = [
            "apartment"=> "NA",
            "email"=> $shippingAddress->user->email,
            "floor"=> "NA",
            "first_name"=> $shippingAddress->user->name ,
            "street"=> $shippingAddress->address,
            "building"=> "NA",
            "phone_number"=> $shippingAddress->phone,
            "shipping_method"=> "NA",
            "postal_code"=>$shippingAddress->postal_code,
            "city"=> $shippingAddress->city->title,
            "country"=> "NA",
            "last_name"=> $shippingAddress->user->name ,
            "state"=> $shippingAddress->governorate->title
        ];
        $data=[
            "auth_token"=>$token,
            "amount_cents"=>$total_amount_cents,
            "expiration"=>3600,
            "order_id"=>$order_id,
            "currency"=> "EGP",
            "integration_id"=>config('services.paymob.integration_id'),
            "billing_data"=>$billingData,
        ];
        return Http::post($this->baseUrl.'/acceptance/payment_keys',$data);
    }

    public function paymentCallback(Request $request): bool|array
    {
        $data = $request->all();
        ksort($data);
        $hmac = $data['hmac'];
        $arrayKeys = [
            'amount_cents',
            'created_at',
            'currency',
            'error_occured',
            'has_parent_transaction',
            'id',
            'integration_id',
            'is_3d_secure',
            'is_auth',
            'is_capture',
            'is_refunded',
            'is_standalone_payment',
            'is_voided',
            'order',
            'owner',
            'pending',
            'source_data_pan',
            'source_data_sub_type',
            'source_data_type',
            'success'
        ];
        $concatenatedString = '';
        foreach ($data as $key=>$value)
        {
            if (in_array($key,$arrayKeys))
                $concatenatedString.=$value;
        }

        $hmacSecret = config('services.paymob.hmac');
        $hashedHmac = hash_hmac('SHA512',$concatenatedString,$hmacSecret);
        if ($hashedHmac == $hmac && $data['success'])
            return $data;
        return false;
    }

    public function payCredit($order_id , $items, $userAddress,$total_amount_cents): array
    {
        $order_items = [];
//        payment process to return iframe for billing ;
        if (count($items)){
            foreach ($items as $item) {
                $order_items[] = [
                    "name" => $item->product->name,
                    "amount_cents" => $item->price * 100,
                    "description" => $item->product->description,
                    "quantity" => $item['quantity']
                ];
            }
        }

        $token = $this->getAuthToken();
        $itemsData = [
            "auth_token" => $token,
            "delivery_needed" => "false",
            "amount_cents" => $total_amount_cents,
            "currency" => "EGP",
            'merchant_order_id' => $order_id,
            "items" => $order_items
        ];
        $paymob_order = $this->createOrder($itemsData);
        if (!$paymob_order->successful())
            return ['status' => false, 'data' => collect($paymob_order->object())->toArray()];
        $paymob_order = $paymob_order->object();
        $response = $this->getPaymentToken($paymob_order->id, $token, $total_amount_cents, $userAddress);
        if (!$response->successful())
            return ['status' => false, 'data' => collect($response->object())->toArray()];
        if ($response->successful())
            $paymentToken = $response->object()->token;
        return ['status' => true, "data" => config('services.paymob.iframe_url') . "?payment_token={$paymentToken}"];
    }
}
