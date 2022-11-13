<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = ['name','num_nabadat','price'];

    public function users(){
        return $this->belongsToMany(user::class);
    }
}
