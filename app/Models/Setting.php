<?php

namespace App\Models;

use App\Services\FileService;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Add a settings value
     *
     * @param $key
     * @param $val
     * @param string $type
     * @return bool
     */
    public static function add($key, $val, $type = 'string')
    {
        if ($key == 'company_logo'){
            $fileData = FileService::saveImage(file: $val,path: 'uploads/settings');
            $val = $fileData['filename'];
        }
        
        if ( self::has($key) ) {
            if ($key == 'company_logo'){
                $company_logo = self::get('general', 'company_logo');
                FileService::remove(public_path('uploads/settings/'.$company_logo));
            }
            return self::set($key, $val, $type);
        }
        return self::create(['name' => $key, 'val' => $val, 'type' => $type]) ? $val : false;
    }

    /**
     * Get a settings value
     *
     * @param $key
     * @param null $default
     * @return bool|int|mixed
     */
    public static function get(string $parent, $key, $default = null)
    {
        if ( self::has($key) ) {
            $setting = self::getAllSettings()->where('name', $key)->first();
            return self::castValue($setting->val, $setting->type);
        }

        return self::getDefaultValue($parent, $key, $default);
    }

    /**
     * Set a value for setting
     *
     * @param $key
     * @param $val
     * @param string $type
     * @return bool
     */
    public static function set($key, $val, $type = 'string')
    {
        if ( $setting = self::getAllSettings()->where('name', $key)->first() ) {
            return $setting->update([
                'name' => $key,
                'val' => $val,
                'type' => $type]) ? $val : false;
        }

        return self::add($key, $val, $type);
    }

    /**
     * Remove a setting
     *
     * @param $key
     * @return bool
     */
    public static function remove($key)
    {
        if( self::has($key) ) {
            return self::whereName($key)->delete();
        }

        return false;
    }

    /**
     * Check if setting exists
     *
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return (boolean) self::getAllSettings()->whereStrict('name', $key)->count();
    }

    /**
     * Get the validation rules for setting fields
     *
     * @return array
     */
    public static function getValidationRules(string $parent)
    {
        return self::getDefinedSettingFields($parent)->pluck('rules', 'name')
            ->reject(function ($val) {
            return is_null($val);
        })->toArray();
    }

    /**
     * Get the data type of a setting
     *
     * @param $field
     * @return mixed
     */
    public static function getDataType(string $parent, $field)
    {
        $type  = self::getDefinedSettingFields($parent)
                ->pluck('data', 'name')
                ->get($field);

        return is_null($type) ? 'string' : $type;
    }

    /**
     * Get default value for a setting
     *
     * @param $field
     * @return mixed
     */
    public static function getDefaultValueForField(string $parent, $field)
    {
        return self::getDefinedSettingFields($parent)
                ->pluck('value', 'name')
                ->get($field);
    }

    /**
     * Get default value from config if no value passed
     *
     * @param $key
     * @param $default
     * @return mixed
     */
    private static function getDefaultValue(string $parent, $key, $default)
    {
        return is_null($default) ? self::getDefaultValueForField($parent, $key) : $default;
    }

    /**
     * Get all the settings fields from config
     *
     * @return Collection
     */
    private static function getDefinedSettingFields(string $parent)
    {
        return collect(config('setting_fields.'.$parent)['elements']);
        
    }

    /**
     * caste value into respective type
     *
     * @param $val
     * @param $castTo
     * @return bool|int
     */
    private static function castValue($val, $castTo)
    {
        switch ($castTo) {
            case 'int':
            case 'integer':
                return intval($val);
                break;

            case 'bool':
            case 'boolean':
                return boolval($val);
                break;

            default:
                return $val;
        }
    }

    /**
     * Get all the settings
     *
     * @return mixed
     */
    public static function getAllSettings()
    {
        return Cache::rememberForever('settings.all', function() {
            return self::all();
        });
    }

    /**
     * Flush the cache
     */
    public static function flushCache()
    {
        Cache::forget('settings.all');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::created(function() {
            self::flushCache();
        });
    }
}