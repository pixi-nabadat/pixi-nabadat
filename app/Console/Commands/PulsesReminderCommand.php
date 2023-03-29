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
            $users = app()->make(UserService::class)->queryGet(where_condition: [], withRelation: [])
            ->WalletGreaterThan(0, 3)->get();
            ScheduleFcm::UserReminderFcm($scheduleFcmNabadatThreeDays, $users);
        }
        if($scheduleFcmNabadatSevenDays)
        {
            $users = app()->make(UserService::class)->queryGet(where_condition: [], withRelation: [])
            ->WalletGreaterThan(0, 7)->get();
            ScheduleFcm::UserReminderFcm($scheduleFcmNabadatSevenDays, $users);
        }
        if($scheduleFcmNabadatElevenDays)
        {
            $users = app()->make(UserService::class)->queryGet(where_condition: [], withRelation: [])
            ->WalletGreaterThan(0, 11)->get();
            ScheduleFcm::UserReminderFcm($scheduleFcmNabadatElevenDays, $users);
        }
        //end nabadat usage reminder
        return Command::SUCCESS;
    }
}
