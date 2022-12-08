<?php

if (!function_exists('apiResponse')) {
     function apiResponse($data = null, $message = null , $code = 200){
        $array = [
            'data' => $data,
            'status' => in_array($code , successCode()),
            'message' => $message,
        ];
        return response($array , $code);
    }
}

if (!function_exists('successCode')) {
    function successCode(): array
    {
        return [
            200 , 201 , 202
        ];
    }
}


if (!function_exists('getPriceAfterDiscount')) {
    function getPriceAfterDiscount(int $price,int $discountValue)
    {
            return  $price - ($price * ($discountValue/100));
    }
}
if (!function_exists('getDateOfSpecificDay')) {

    function getDateOfSpecificDay($day,$date): \Carbon\Carbon
    {
        $dayOfWeek = $date->dayOfWeek;

        if ($dayOfWeek != (int) $day)
        {
            $date = $date->addDay();
            $date = getDateOfSpecificDay($day,$date);
        }
        return $date ;
    }
}




