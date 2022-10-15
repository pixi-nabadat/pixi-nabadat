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
}
