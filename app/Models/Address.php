<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory,Filterable;
    protected $fillable = [
    'user_id','address', 'country_id', 'governerate_id', 'phone', 'city_id',
    'postal_code','is_default','lat','lng'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
