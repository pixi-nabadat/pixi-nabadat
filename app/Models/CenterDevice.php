<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class CenterDevice extends Model
{
    use HasFactory,Filterable;
    protected $fillable = ['center_id','device_id','regular_price', 'nabadat_app_price','auto_service_price','number_of_devices'];


    public function center(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Center::class,'center_id');
    }

    public function device(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Device::class,'device_id');
    }

}
