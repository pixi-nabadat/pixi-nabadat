<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __invoke()
    {
        return auth()->user();
       return view('dashboard.index');
    }
}
