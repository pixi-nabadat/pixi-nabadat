<?php

namespace App\Services;


use GuzzleHttp\Client;

class SmsService extends BaseService
{

    public function __construct(protected UserService $userService)
    {
    }

    public function sendSMS(array $phones = [], string $message)
    {   	
        $user = "Nabadat";
        $pwd = "m_4_bmp4";
        $senderid = "N???ABADAT";
        $countryCode = "+20";
        $msgtext = $message;
        foreach($phones as $phone)
        {
            $mobileno = $phone;
            $url = "http://www.mshastra.com/sendurlcomma.aspx?user=".$user."&pwd=".$pwd."&senderid=".$senderid."&CountryCode=".$countryCode."&mobileno=".$mobileno."&msgtext=".$msgtext;
            // Import the Guzzle namespace
    
            // Create a new Guzzle client instance
            $client = new Client();
    
            // Send a GET request to a URL
            $response = $client->get($url);
    
            // Get the response body as a string
            $body = $response->getBody()->getContents();
        }

        // Process the response
        return true;
		
    }

}