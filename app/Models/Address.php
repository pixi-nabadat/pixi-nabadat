<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'user_id', 'address', 'country_id', 'governerate_id', 'phone', 'city_id',
        'postal_code', 'is_default', 'lat', 'lng'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'city_id');
    }

    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'governerate_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return int|null
     */
    public function getShippingCostAttribute(): int|null
    {
        return $this->relationLoaded('city') ? $this->city->shipping_cost : 0;
    }
}
