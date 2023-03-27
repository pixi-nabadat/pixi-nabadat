<?php

namespace App\Console\Commands;

use App\Enum\FcmEventsNames;
use App\Models\Reservation;
use App\Models\ScheduleFcm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\PushNotificationService;
use App\Services\ReservationService;

class FcmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcm:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send fcm notification for users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $reservationsOneDayRemain = Reservation::query()->whereHas('latestStatus',fn($query)=>$query->where('status',Reservation::CONFIRMED))
        ->where('check_date', Carbon::parse(Carbon::now()->addDays(2))->format('Y-m-d'))->get();
        
        $reservationsTwoDaysRemain = Reservation::query()->whereHas('latestStatus',fn($query)=>$query->where('status',Reservation::CONFIRMED))
        ->where('check_date', Carbon::parse(Carbon::now()->addDays(3))->format('Y-m-d'))->get();
        
        $scheduleFcmOneDay  = ScheduleFcm::query()
        ->where('is_active', 1)
        ->where('trigger', FcmEventsNames::$EVENTS['ONE_DAY_BEFORE_RESERVATION'])
        ->first();
        $scheduleFcmTwoDays = ScheduleFcm::query()
        ->where('is_active', 1)
        ->where('trigger', FcmEventsNames::$EVENTS['TWO_DAYS_BEFORE_RESERVATION'])
        ->first();
        
        
        if($scheduleFcmOneDay)
        {
            
            //prepare data
            $title = $scheduleFcmOneDay->title ;
            $body = $scheduleFcmOneDay->content ;
            foreach($reservationsOneDayRemain as $reservation)
            {
                $replaced_values = [
                    '@USER_NAME@'=>$reservation->user->name,
                    '@EXPIRE_DATE@'=>$reservation->check_date,
                    '@RESERVATION_NUMBER@'=>$reservation->id,
                    '@RESERVATION_STATUS@'=> $reservation->latestStatus,
                    '@CENTER_NAME@'=>$reservation->center->user->name,
                    '@CENTER_LOCATION@'=>$reservation->center->user->location->title,
                ];
                $body = replaceFlags($body,$replaced_values);
                // $tokens = $usersToken->toArray();
                $tokens[0] = $reservation->user->device_token;
                app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);
    
            }

        }

        if($scheduleFcmTwoDays)
        {
            
            //prepare data
            $title = $scheduleFcmTwoDays->title ;
            $body = $scheduleFcmTwoDays->content ;
            foreach($reservationsTwoDaysRemain as $reservation)
            {
                $replaced_values = [
                    '@USER_NAME@'=>$reservation->user->name,
                    '@EXPIRE_DATE@'=>$reservation->check_date,
                    '@RESERVATION_NUMBER@'=>$reservation->id,
                    '@RESERVATION_STATUS@'=> $reservation->latestStatus,
                    '@CENTER_NAME@'=>$reservation->center->user->name,
                    '@CENTER_LOCATION@'=>$reservation->center->user->location->title,
                ];
                $body = replaceFlags($body,$replaced_values);
                // $tokens = $usersToken->toArray();
                $tokens[0] = $reservation->user->device_token;
                app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);
    
            }

        }
        
        return Command::SUCCESS;
    }
}
