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
    function getPriceAfterDiscount(int $price,int $discountValue,$discountType=\App\Enum\DiscountEnum::PERCENTAGE)
    {
        if ($discountType == \App\Enum\DiscountEnum::PERCENTAGE)
            return  $price - ($price * ($discountValue/100));
        if ($discountType == \App\Enum\DiscountEnum::FLAT)
            return  $price - $discountValue ;
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
if (! function_exists('setting')) {

    function setting($parent, $key, $default = null)
    {
        if (is_null($key)) {
            return new \App\Models\Setting();
        }

        if (is_array($key)) {
            return \App\Models\Setting::set($key[0], $key[1]);
        }

        $value = \App\Models\Setting::get($parent, $key);

        return is_null($value) ? value($default) : $value;
    }
}



