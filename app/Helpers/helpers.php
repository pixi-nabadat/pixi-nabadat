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







