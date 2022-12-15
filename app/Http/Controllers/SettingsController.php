<?php

namespace App\Http\Controllers;


class SettingsController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }
}
