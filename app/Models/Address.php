<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Address extends Model
{
    use HasFactory,Filterable;
    protected $fillable = [
    'user_id','address', 'country_id', 'governerate_id', 'phone', 'city_id',
    'postal_code','is_default','lat','lng'];
}
