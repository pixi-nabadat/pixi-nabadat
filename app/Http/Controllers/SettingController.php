<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Setting;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    public function index()
    {
        return view('dashboard.setting.index');
    }

    public function appSettingsIndex()
    {
        $locations = Location::all();
        return view('dashboard.setting.general', compact('locations'));
    }

    public function pointsSettingsIndex()
    {
        return view('dashboard.setting.points');
    }

    public function socialMediaSettingsIndex()
    {
        return view('dashboard.setting.social_media');
    }

    public function termsAndConditionsSettingsIndex()
    {
        return view('dashboard.setting.terms_and_conditions');
    }

    public function store(Request $request)
    {
        $parent = $request->segment(3);
        $rules = Setting::getValidationRules($parent);
        $data = $this->validate($request, $rules);

        $validSettings = array_keys($rules);

        foreach ($data as $key => $val) {
            if (in_array($key, $validSettings)) {
                Setting::add($key, $val, Setting::getDataType($parent, $key));
            }
        }
        $toast = ['title' => trans('lang.success'), 'message' => trans('lang.success_operation')];
        return back()->with('toast', $toast);
    }
}
