<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetCodePassword extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'code',
        'created_at',
    ];

    public function isExpire()
    {
        if ($this->created_at > now()->addMinutes(30)) {
            $this->delete();
        }
    }
}
