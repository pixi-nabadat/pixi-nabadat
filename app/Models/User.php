<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const SUPERADMINTYPE = 1;
    const CUSTOMERTYPE = 2;
    const DOCTORTYPE = 3;
    const CENTERTYPE = 4;

    const ACTIVE = 1;
    const NONACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'type',
        'last_login', 'date_of_birth', 'is_active','location_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the user's first name.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->createToken(config('app.name'))->plainTextToken;
    }

}
