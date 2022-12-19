<?php

namespace App\Models;

use App\Observers\OrderHistoryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','status'];

    protected static function boot()
    {
        parent::boot();

        static::observe(OrderHistoryObserver::class);
    }
}
