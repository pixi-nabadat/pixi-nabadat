<?php

namespace App\Console\Commands;

use App\Enum\FcmEventsNames;
use App\Models\Reservation;
use App\Models\ScheduleFcm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\PushNotificationService;

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

        $reservations = Reservation::query()
        ->where('check_date', Carbon::parse(Carbon::now()->addDay())->format('Y-m-d'))->get();

        // $users = $reservations->pluck('customer_id');
        $scheduleFcm = ScheduleFcm::query()->where('trigger', FcmEventsNames::$EVENTS['ONE_DAY_BEFORE_RESERVATION'])->first();
        
        
        if($scheduleFcm)
        {
            // $usersToken = User::whereIn('id', $users->toArray())->Pluck('device_token');
            
            //prepare data
            $title = $scheduleFcm->title ;
            $body = $scheduleFcm->content ;
            foreach($reservations as $reservation)
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
