<?php
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