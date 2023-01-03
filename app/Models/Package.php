<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasAttachment;

class Package extends Model
{
    use HasFactory,Filterable,HasTranslations,HasAttachment;
    const Active = 1 ;
    const NONActive = 0 ;

    protected $fillable = ['center_id','name','num_nabadat','price','start_date','end_date','discount_percentage','is_active'];
    public $translatable =['name'];

    public function subscriber(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserPackage::class);
    }


    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
