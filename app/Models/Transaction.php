<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','package_id','invoice_id','num_pulses','center_dues','nabadat_app_dues','original_price','center_discount','user_discount'];


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function invoice(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public static function createTransaction(UserPackage $userPackage,$invoice_id)
    {
        $final_discount = $userPackage->center->app_discount - $userPackage->discount_percentage;
//        center dues
        $center_dues = $userPackage->price - ($userPackage->price * ($userPackage->center->app_discount / 100));
        $nabadat_app_dues =($final_discount > 0) ?  ($userPackage->price * ($final_discount/ 100)):0;
        $center_financial_data = [
            'invoice_id' => $invoice_id,
            'user_id' => $userPackage->user_id,
            'package_id' => $userPackage->package_id,
            'num_pulses' => $userPackage->num_nabadat,
            'center_dues' =>$center_dues,
            'nabadat_app_dues' =>$nabadat_app_dues,
            'original_price' => $userPackage->price,
            'center_discount' => $userPackage->center->app_discount,
            'user_discount' => $userPackage->discount_percentage,
            'date' => Carbon::now(config('app.africa_timezone'))->format('Y-m-d'),
        ];
        self::create($center_financial_data);
    }

}