<?php

if (!function_exists('apiResponse')) {
    function apiResponse($data = null, $message = null, $code = 200)
    {
        $array = [
            'data' => $data,
            'status' => in_array($code, successCode()),
            'message' => $message,
        ];
        return response($array, $code);
    }
}

if (!function_exists('successCode')) {
    function successCode(): array
    {
        return [
            200, 201, 202
        ];
    }
}


if (!function_exists('getPriceAfterDiscount')) {
    function getPriceAfterDiscount(int $price, float $discountValue, $discountType = \App\Enum\DiscountEnum::PERCENTAGE)
    {
        if ($discountType == \App\Enum\DiscountEnum::PERCENTAGE)
            return round($price - ($price * ($discountValue / 100)),3);
        if ($discountType == \App\Enum\DiscountEnum::FLAT)
            return $price - $discountValue;
    }
}
if (!function_exists('getDateOfSpecificDay')) {

    function getDateOfSpecificDay($day, $date): \Carbon\Carbon
    {
        $dayOfWeek = $date->dayOfWeek;

        if ($dayOfWeek != (int)$day) {
            $date = $date->addDay();
            $date = getDateOfSpecificDay($day, $date);
        }
        return $date;
    }
}
if (! function_exists('getReservationDates')) {
    function getReservationDates(array $days=[])
    {
        $date = \Carbon\Carbon::now();
        $appointments = collect();
        for ($start =  0 ; $start <=31 ; $start++)
        {
            $appointment = [
                'day_of_week' => $date->dayOfWeek,
                'date' => $date->format('Y-m-d'),
                'day_en' => $date->locale('en')->dayName,
                'day_ar' => $date->locale('ar')->dayName,
            ];
            $appointments->push($appointment);
            $date->addDay();
        }
        return array_values($appointments->whereIn('day_of_week',$days)->take(7)->toArray());
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

if (!function_exists('sendFCMToTokens')) {

    function sendFCMToTokens(array $tokens = [], string $title = '', string $body = '', array $data = [])
    {

        $fcm_key = config('services.fcm.key');
        $data = [
            "notification" => [

                "title" => $title,

                "body" => $body,

                "sound" => "default" // required for sound on ios

            ],

        ];
        $data['registration_ids'] = $tokens;

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $fcm_key,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        return $response;
    }
}

if (!function_exists('replaceFlags')) {

    function replaceFlags($content,$values =[])
    {
        if (count($values)){
            foreach (\App\Enum\FcmEventsNames::$FLAGS as $FLAG)
            {
                if (isset($values[$FLAG]))
                    $content = str_replace($FLAG,$values[$FLAG],$content);
            }
        }
        return $content;

    }
}
if (!function_exists('notifyUser')) {

    function notifyUser(\App\Models\User $user,$data=[])
    {
        $user->notify(new \App\Notifications\GeneralNotification($data));
    }
}

if (!function_exists('getLocale')) {

    function getLocale(): string
    {
        return app()->getLocale();
    }
}


if (!function_exists('setLanguage')) {

    function setLanguage(string $locale): void
    {
        app()->setLocale($locale);
    }
}


if (!function_exists('changePointsToPounds')) {

    function changePointsToPounds(float $points): float
    {
        return $points * setting('points','patient_points_per_pound');
    }
}

if (!function_exists('changeCenterPointsToPounds')) {

    function changeCenterPointsToPounds(float $points): float
    {
        return $points / setting('points','center_points_per_pound');
    }
}


if (!function_exists('changeCenterPoundsToPoints')) {

    function changeCenterPoundsToPoints(float $pounds): float
    {
        return $pounds * setting('points','center_points_per_pound');
    }
}