<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class FcmMessage extends Model
{
    use HasFactory, Filterable;

    public const CREATE_NEW_ORDER = 'CREATE_NEW_ORDER';
    public const CHANGE_ORDER_STATUS = 'CHANGE_ORDER_STATUS';
    public const CREATE_USER_RESERVATION = 'CREATE_USER_RESERVATION';
    public const CHANGE_RESERVATION_STATUS = 'CHANGE_RESERVATION_STATUS';
    public const COMPLETE_USER_RESERVATION = 'COMPLETE_USER_RESERVATION';
    public const DEAL_WITH_NEW_CENTER = 'DEAL_WITH_NEW_CENTER';
    public const CENTER_CREATE_NEW_OFFER = 'CENTER_CREATE_NEW_OFFER';
    public const CREATE_NEW_COUPON_DISCOUNT = 'CREATE_NEW_COUPON_DISCOUNT';

    protected $fillable = ['title','content','fcm_action','is_active'];

}
