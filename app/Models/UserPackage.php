<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;


class UserPackage extends Model
{
    use HasFactory,Filterable;

    protected $fillable = ['num_nabadat','price','user_id','package_id'];
}
