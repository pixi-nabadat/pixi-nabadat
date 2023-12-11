<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class LocalizationController extends Controller
{

    public function setLang($locale)
    {
        if (!in_array($locale,config('app.availableLocales'))) {
            abort(400);
        }
        $user = auth('sanctum')->user();
        $user->lang = $locale;
        $user->save();
        setLanguage($locale);
        return response()->json(data: [
            'status'=>true,
            'message'=>trans('lang.success_operation'),
            'lang'=>$locale,

        ], status: 200);

    }

    public function getLang()
    {
        $user = auth('sanctum')->user();
        $user->save();
        return response()->json(data: [
            'status'=>true,
            'lang'=>$user->lang,
        ], status: 200);
    }
}
