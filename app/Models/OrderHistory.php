<?php

namespace App\Models;

use App\Observers\OrderHistoryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','status'];

    public function getStatusTextAttribute()
    {
        switch ((int) $this->status)
        {
            case Order::PENDING:
                return trans('lang.pending');

            case Order::CONFIRMED:
                return trans('lang.confirmed');

            case Order::SHIPPED:
                return trans('lang.shipped');

            case Order::DELIVERED:
                return trans('lang.delivered');

            case Order::CANCELED:
                return trans('lang.canceled');
        }
    }
    protected static function boot()
    {
        parent::boot();

        static::observe(OrderHistoryObserver::class);
    }
}
