<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['address', 'country_id', 'governerate_id', 'phone', 'city_id','postal_code','is_default'];
}
