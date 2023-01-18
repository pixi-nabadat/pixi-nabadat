<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\HasAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;
class Doctor extends Model
{
    use HasTranslations, HasFactory,Filterable,HasAttachment,EscapeUnicodeJson;

    const   ACTIVE      = 1 ,
            NON_ACTIVE  = 0 ;

    protected $fillable = ['name','description','phone','center_id', 'age'];

    public $translatable = ['name','description'];

    protected $casts =[
      'phone'  => 'array'
    ];

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

}
