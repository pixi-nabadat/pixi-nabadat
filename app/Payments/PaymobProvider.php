<?php

namespace App\Payments;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
class PaymobProvider
{
    private $authRequestUrl;
    private $orderRegisterationAPiUrl;
    private $paymentKeyRequestUrl;
    private $headers;
    public function __construct()
    {
        $this->authRequestUrl           = 'https://accept.paymob.com/api/auth/tokens';
        $this->orderRegisterationAPiUrl = 'https://accept.paymob.com/api/ecommerce/orders';
        $this->paymentKeyRequestUrl     = 'https://accept.paymob.com/api/acceptance/payment_keys?&';
        $this->headers = [
            "Accept"=>"application/json",
            "Content-Type"=>"application/json"
        ];
    }

    private function buildRequest(string $url, array $headers, array $data)
    {
        $response = Http::withHeaders($headers)->post(url: $url, data: $data)->json();
        return $response;
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

        $data = [
            "api_key"=>"ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SndjbTltYVd4bFgzQnJJam96TURNd01Ua3NJbTVoYldVaU9pSXhOamN3T1RZek1UQTJMakUyTkRFM09TSXNJbU5zWVhOeklqb2lUV1Z5WTJoaGJuUWlmUS45UEdBNWZZakc3bWdEbkVuZVZmNnE4U2JfY3NReTl4UTI4c0VERmg4RDhjanFFT0Y4aFg4MG5PdVhuOUFlNWFFRDFsYzMtNXVFNUZ1c1RXSklPcTNlUQ=="
        ];

        $response = $this->buildRequest(url: $this->authRequestUrl, headers: $this->headers, data: $data);
        return $response['token'];
    }

    private function orderRegisterationAPi(string $token)
    {
        $data = 
            [
                "auth_token"=> $token,
                "delivery_needed"=> "false",
                "amount_cents"=> "100",
                "currency"=> "EGP",
                "merchant_order_id"=> 165,
                "items"=> [
                  [
                      "name"=> "ASC1515",
                      "amount_cents"=> "500000",
                      "description"=> "Smart Watch",
                      "quantity"=> "1"
                  ],
                  [ 
                      "name"=> "ERT6565",
                      "amount_cents"=> "200000",
                      "description"=> "Power Bank",
                      "quantity"=> "1"
                  ]
                ],
                "shipping_data"=> [
                  "apartment"=> "803", 
                  "email"=> "claudette09@exa.com", 
                  "floor"=> "42", 
                  "first_name"=> "Clifford", 
                  "street"=> "Ethan Land", 
                  "building"=> "8028", 
                  "phone_number"=> "+86(8)9135210487", 
                  "postal_code"=> "01898", 
                   "extra_description"=> "8 Ram , 128 Giga",
                  "city"=> "Jaskolskiburgh", 
                  "country"=> "CR", 
                  "last_name"=> "Nicolas", 
                  "state"=> "Utah"
                ],
                  "shipping_details"=> [
                      "notes" => " test",
                      "number_of_packages"=> 1,
                      "weight" => 1,
                      "weight_unit" => "Kilogram",
                      "length" => 1,
                      "width" =>1,
                      "height" =>1,
                      "contents" => "product of some sorts"
                  ]
            ];
        $response = $this->buildRequest(url: $this->orderRegisterationAPiUrl, headers: $this->headers, data: $data);
        return ['orderId'=>$response['id'], 'token'=>$response['token'], ];
    }
    
    private function paymentKeyRequest(string $token , int $orderId)
    {

        $data = [
            "auth_token"=> $token,
            "amount_cents"=> "100", 
            "expiration"=> 3600, 
            "order_id"=> $orderId,
            "billing_data"=> [
              "apartment"=> "803", 
              "email"=> "claudette09@exa.com", 
              "floor"=> "42", 
              "first_name"=> "Clifford", 
              "street"=> "Ethan Land", 
              "building"=> "8028", 
              "phone_number"=> "+86(8)9135210487", 
              "shipping_method"=> "PKG", 
              "postal_code"=> "01898", 
              "city"=> "Jaskolskiburgh", 
              "country"=> "CR", 
              "last_name"=> "Nicolas", 
              "state"=> "Utah"
            ], 
            "currency"=> "EGP", 
            "integration_id"=> 2587202,
            "lock_order_when_paid"=> "false"
        ];
        $response = $this->buildRequest(url: $this->paymentKeyRequestUrl, headers: $this->headers, data: $data);

        return $response['token'];
    }
}
