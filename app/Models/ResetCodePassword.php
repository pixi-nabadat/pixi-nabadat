<?php

namespace App\Models;

use App\Services\SmsService;
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
            return true;
        }else
            return false;
        
    }

    public static function sendCode(string $phone)
    {
        $otpData = [
            'phone' => $phone,
            'code' => mt_rand(100000, 999999),
            'created_at' => now(),
            'updated_at' => now()
        ];
        ResetCodePassword::where('phone', $otpData['phone'])->delete();
        // Create a new code
        $codeData = ResetCodePassword::create($otpData);
        //Todo send sms or slack notification with code
        //logic code of sending code here

         if ($codeData)
        {
            $message = 'Your OTP Code is: '.$codeData->code;
            $phone = [$otpData['phone']];
            app()->make(SmsService::class)->sendSMS(phones: $phone, message: $message);
        }
    }
}
