<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class CenterDevice extends Model
{
    use HasFactory,Filterable;
    protected $fillable = ['regular_price', 'nabadat_app_price','auto_service_price','number_of_devices'];

}
