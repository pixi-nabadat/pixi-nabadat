<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;

class Center extends Model
{
    use HasTranslations, HasFactory,Filterable;

    const   ACTIVE = 1 ,
            SUPPORT_AUTO_SERVICE = 1,
            NON_ACTIVE = 0 ,
            NON_SUPPORT_AUTO_SERVICE = 0;

    protected $fillable = [
        'name', 'phone', 'is_active', 'location_id' ,'lat','lng','is_support_auto_service','address','description',
        'google_map_url'
    ];

    protected $casts = [
        'phone' => 'array',
    ];

    protected $table = 'centers';

    public $timestamps = false;

    public $translatable = ['name','description','address'];


    public function location()
    {
        return $this->belongsTo(Location::class);
    }


}
