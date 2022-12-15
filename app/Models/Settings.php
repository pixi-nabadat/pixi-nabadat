<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    public $timestamps = false;
    public array $predefined_pages = [
        'general',
        'sms',
        'terms_of_condition',
        'app_notifications',
        'region_and_location'
    ];
    protected $fillable = ['name', 'value'];

    public function setValueAttribute($value): bool|string
    {
        return json_encode($value);
    }

    public function getValueAttribute($value): bool|string
    {
        return json_decode($value, true);
    }

}
