<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index');
    }

    public function appSettingsIndex()
    {
        return view('setting.app');
    }

    public function pointsSettingsIndex()
    {
        return view('setting.points');
    }

    public function store(Request $request)
    {
        $parent = "points"; // may be app, points ....
        $rules = Setting::getValidationRules($parent);
        $data = $this->validate($request, $rules);

        $validSettings = array_keys($rules);

        foreach ($data as $key => $val) {
            if (in_array($key, $validSettings)) {
                Setting::add($key, $val, Setting::getDataType($parent, $key));
            }
        }

        return redirect()->back()->with('status', 'Settings has been saved.');
    }
}
