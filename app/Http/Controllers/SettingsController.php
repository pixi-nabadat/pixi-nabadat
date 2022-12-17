<?php

namespace App\Http\Controllers;


use App\Services\SettingService;

class SettingsController extends Controller
{
    public function __construct(protected SettingService $authService)
    {
    }
}
