<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNabadatWallet extends Model
{
    use HasFactory;
    const ONGOING = 1 ;
    const COMPLETED = 2;
    const CASH = 1;
    const CREDIT_CARD = 2 ;
    protected $fillable = ['user_id','total_pulses','used_pulses','status'];

    public function subscriber(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
