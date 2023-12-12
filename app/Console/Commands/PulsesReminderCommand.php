<?php

namespace App\Console\Commands;

use App\Enum\FcmEventsNames;
use App\Models\ScheduleFcm;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PulsesReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pulses-reminder:notification';

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
        //start nabadat usage reminder
        $scheduleFcmForPulses  = ScheduleFcm::query()
        ->where('is_active', 1)
        ->whereIn('trigger', [FcmEventsNames::$EVENTS['NABADAT_NOT_USED_FOR_3'],FcmEventsNames::$EVENTS['NABADAT_NOT_USED_FOR_7'],FcmEventsNames::$EVENTS['NABADAT_NOT_USED_FOR_11']])
        ->get();

        $scheduleFcmNabadatThreeDays = $scheduleFcmForPulses->where('trigger',FcmEventsNames::$EVENTS['NABADAT_NOT_USED_FOR_3'])->first();
        
        $scheduleFcmNabadatSevenDays = $scheduleFcmForPulses->where('trigger',FcmEventsNames::$EVENTS['NABADAT_NOT_USED_FOR_7'])->first();
        
        $scheduleFcmNabadatElevenDays = $scheduleFcmForPulses->where('trigger',FcmEventsNames::$EVENTS['NABADAT_NOT_USED_FOR_11'])->first();


        if($scheduleFcmNabadatThreeDays)
        {
            $users = app()->make(UserService::class)->queryGet()
            ->walletGreaterThan(minimum_number_of_pulses:0,days_number:3)->get();
            // ScheduleFcm::UserReminderFcm($scheduleFcmNabadatThreeDays, $users);
            ScheduleFcm::sendNotification(users: $users, scheduleFcm: $scheduleFcmNabadatThreeDays);

        }
        if($scheduleFcmNabadatSevenDays)
        {
            $users = app()->make(UserService::class)->queryGet()
            ->walletGreaterThan(minimum_number_of_pulses:0,days_number: 7)->get();
            // ScheduleFcm::UserReminderFcm($scheduleFcmNabadatSevenDays, $users);
            ScheduleFcm::sendNotification(users: $users, scheduleFcm: $scheduleFcmNabadatSevenDays);
        }
        if($scheduleFcmNabadatElevenDays)
        {
            $users = app()->make(UserService::class)->queryGet()
            ->walletGreaterThan(minimum_number_of_pulses:0, days_number:11)->get();
            // ScheduleFcm::UserReminderFcm($scheduleFcmNabadatElevenDays, $users);
            ScheduleFcm::sendNotification(users: $users, scheduleFcm: $scheduleFcmNabadatElevenDays);
        }
        //end nabadat usage reminder
        return Command::SUCCESS;
    }
}
