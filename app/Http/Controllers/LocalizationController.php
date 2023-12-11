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
        $expire_in = 365 * 60 * 24;
        $previous_url = str_replace(url('/'), '', url()->previous());
        return redirect($previous_url)->cookie('user-language', $locale,$expire_in);

    }
}
