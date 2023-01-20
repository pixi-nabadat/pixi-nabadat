<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'center_id', 'package_id', 'num_pulses', 'center_dues', 'app_dues', 'regular_price', 'center_discount', 'user_discount','status', 'date',
    ];

    public static function createFinancial(UserPackage $userPackage)
    {
        $final_discount = $userPackage->center->app_discount - $userPackage->discount_percentage;
        $center_financial_data = [
            'user_id' => $userPackage->user_id,
            'center_id' => $userPackage->center_id,
            'package_id' => $userPackage->package_id,
            'num_pulses' => $userPackage->num_nabadat,
            'center_dues' => $userPackage->price - ($userPackage->price * ($userPackage->center->app_discount / 100)),
            'app_dues' => ($final_discount > 0) ?  ($userPackage->price * ($final_discount/ 100)):0,
            'regular_price' => $userPackage->price,
            'center_discount' => $userPackage->center->app_discount,
            'user_discount' => $userPackage->discount_percentage,
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
