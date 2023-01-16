<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CenterFinancial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'center_id', 'package_id', 'num_pulses', 'center_dues', 'nabadat_dues', 'regular_price', 'discount', 'status', 'date',
    ];

    public static function createFinancial(UserPackage $userPackage)
    {
        $center_financial_data = [
            'user_id' => $userPackage->user_id,
            'center_id' => $userPackage->center_id,
            'package_id' => $userPackage->package_id,
            'num_pulses' => $userPackage->num_nabadat,
            'center_dues' => $userPackage->price - ($userPackage->price * ($userPackage->center->app_discount / 100)),
            'nabadat_dues' => $userPackage->price - ($userPackage->price * (($userPackage->center->app_discount - $userPackage->discount_percentage) / 100)),
            'regular_price' => $userPackage->price,
            'discount' => $userPackage->discount_percentage,
            'date' => Carbon::now(config('app.africa_timezone'))->format('Y-m-d'),
        ];
        self::create($center_financial_data);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'center_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
