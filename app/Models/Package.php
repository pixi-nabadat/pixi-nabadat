<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;

class Package extends Model
{
    use HasFactory,Filterable,HasTranslations;
    const Active = 1 ;
    const NONActive = 0 ;
    
    protected $fillable = ['name','num_nabadat','price','is_active'];
    public $translatable =['name'];

    public function subscriber()
    {
        return $this->hasMany(UserPackage::class);
    }
}
