<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class ScheduleFcm extends Model
{
    use HasFactory, Filterable;
    protected $fillable = [
        'title',
        'content',
        'trigger',
        'start_date',
        'end_date',
        'notification_via',
        'is_active',
    ];
}
