<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LocalizationController extends Controller
{

    public function __invoke($locale)
    {
        if (!in_array($locale,config('app.availableLocales'))) {
            abort(400);
        }
        $expire_in = 7 * 60 * 24;
        $previous_url = str_replace(url('/'), '', url()->previous());
        $user = Auth::user();
        $user->lang = $locale;
        $user->save();
        setLanguage($locale);
        return redirect($previous_url)->cookie('user-language', $locale,$expire_in);

    }
}
