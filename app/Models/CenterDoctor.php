<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\Pivot;


class CenterDoctor extends Model
{
    use NodeTrait, HasFactory,Filterable;

    protected $fillable = [
        'center_id', 'doctor_id',
    ];

    protected $table = 'center_doctor';

    public $timestamps = false;

}
