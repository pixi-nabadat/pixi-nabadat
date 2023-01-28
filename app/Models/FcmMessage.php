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
    public const CANCEL_CENTER_RESERVATION = 'CANCEL_CENTER_RESERVATION';
    public const COMPLETE_USER_RESERVATION = 'COMPLETE_USER_RESERVATION';
    protected $fillable = ['title','content','fcm_action','is_active'];

}
