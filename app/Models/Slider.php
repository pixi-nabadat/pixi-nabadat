<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slider extends Model
{
    use HasFactory, Filterable;

    //        'duration',
    protected $fillable = ['order', 'center_id', 'start_date', 'end_date', 'is_active',];


    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
