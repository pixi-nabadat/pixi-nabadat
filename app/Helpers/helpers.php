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


if (!function_exists('createDir')) {
    function createDir($fullDir)
    {
        $dir = pathinfo($fullDir, PATHINFO_DIRNAME);
        if (is_dir($dir)) {
            return true;
        }else{
            if (createDir($dir)) {
                if (mkdir($dir, 0777, true)) {
                    return true;
                }
            }
        }
        return false;
    }
}


if (!function_exists('fileDir')) {
    function fileDir($fileType)
    {
        $url = url('/');
        $dir = $url."/uploads/";
        switch ($fileType) {
            case 'profile_photo':
                return $dir.="user/";
                break;
            default:
                return "";
                break;
        }
    }
}






