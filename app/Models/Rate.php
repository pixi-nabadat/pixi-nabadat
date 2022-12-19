<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','status','comment','rate_number','ratable_id','reatable_type'];


    public function ratable()
    {
        return $this->morphTo();
    }
}
