<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;
class Doctor extends Model
{
    use HasTranslations, HasFactory,Filterable;

    protected $fillable = ['name','description','phone','center_id','is_active'];


    const   ACTIVE = 1 ,
            NON_ACTIVE = 0 ;

    protected $table = 'doctors';

    public $timestamps = false;

    public $translatable = ['name','description'];

    protected $casts =[
      'phone'  => 'array'
    ];

    public function center()
    {
        return $this->belongsToMany(Center::class);
    }

}
