<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;
    const   ACTIVE = 1 ,
            SUPPORT_AUTO_SERVICE = 1,
            NON_ACTIVE = 0 ,
            NON_SUPPORT_AUTO_SERVICE = 0;

    protected $fillable = ['name','email','password','google_map_url','phone','description','is_support_auto_service',
    'address','is_active',];
}
