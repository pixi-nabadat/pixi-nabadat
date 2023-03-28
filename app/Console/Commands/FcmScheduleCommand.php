<?php

namespace App\Console\Commands;

use App\Enum\FcmEventsNames;
use App\Models\Reservation;
use App\Models\ScheduleFcm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FcmScheduleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcm_schedule:notification';

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
        //start points expire reminder
        $scheduleFcmPointsOneDay = ScheduleFcm::query()
        ->where('is_active', 1)
        ->where('trigger', FcmEventsNames::$EVENTS['EXPIRE_POINTS_BEFORE_1'])
        ->first();
        $scheduleFcmPointsthreeDays = ScheduleFcm::query()
        ->where('is_active', 1)
        ->where('trigger', FcmEventsNames::$EVENTS['EXPIRE_POINTS_BEFORE_3'])
        ->first();
        $scheduleFcmPointsSevenDays = ScheduleFcm::query()
        ->where('is_active', 1)
        ->where('trigger', FcmEventsNames::$EVENTS['EXPIRE_POINTS_BEFORE_7'])
        ->first();

        if($scheduleFcmPointsOneDay)
        {
            $userPointsOneDayRemain = User::query()
            ->where('points_expire_date', '!=', null)
            ->where('points_expire_date', Carbon::parse(Carbon::now()->addDays(2))->format('Y-m-d'))->get();
            ScheduleFcm::UserReminderFcm($scheduleFcmPointsOneDay, $userPointsOneDayRemain);
        }
        if($scheduleFcmPointsthreeDays)
        {
            $userPointsThreeDaysRemain = User::query()
            ->where('points_expire_date', '!=', null)
            ->where('points_expire_date', Carbon::parse(Carbon::now()->addDays(4))->format('Y-m-d'))->get();
            ScheduleFcm::UserReminderFcm($scheduleFcmPointsthreeDays, $userPointsThreeDaysRemain);
        }
        if($scheduleFcmPointsSevenDays)
        {
            $userPointsSevenDaysRemain = User::query()
            ->where('points_expire_date', '!=', null)
            ->where('points_expire_date', Carbon::parse(Carbon::now()->addDays(8))->format('Y-m-d'))->get();
            ScheduleFcm::UserReminderFcm($scheduleFcmPointsthreeDays, $userPointsSevenDaysRemain);
        }
        //end points expire reminder

        //start nabadat usage reminder
        $scheduleFcmNabadatThreeDays = ScheduleFcm::query()
        ->where('is_active', 1)
        ->where('trigger', FcmEventsNames::$EVENTS['NABADAT_NOT_USED_FOR_3'])
        ->first();
        $scheduleFcmNabadatSevenDays = ScheduleFcm::query()
        ->where('is_active', 1)
        ->where('trigger', FcmEventsNames::$EVENTS['NABADAT_NOT_USED_FOR_7'])
        ->first();
        $scheduleFcmNabadatElevenDays = ScheduleFcm::query()
        ->where('is_active', 1)
        ->where('trigger', FcmEventsNames::$EVENTS['NABADAT_NOT_USED_FOR_11'])
        ->first();
        
        if($scheduleFcmNabadatThreeDays)
        {
            $users = User::query()
            ->whereHas('nabadatWallet',
            fn($query)=>$query
                ->where('total_pulses', '>', 0)
                ->where('updated_at', Carbon::parse(Carbon::now()->addDays(-4))->format('Y-m-d'))
            )->get();
            ScheduleFcm::UserReminderFcm($scheduleFcmNabadatThreeDays, $users);
        }
        if($scheduleFcmNabadatSevenDays)
        {
            $users = User::query()
            ->whereHas('nabadatWallet',
            fn($query)=>$query
                ->where('total_pulses', '>', 0)
                ->where('updated_at', Carbon::parse(Carbon::now()->addDays(-8))->format('Y-m-d'))
            )->get();
            ScheduleFcm::UserReminderFcm($scheduleFcmNabadatSevenDays, $users);
        }
        if($scheduleFcmNabadatElevenDays)
        {
            $users = User::query()
            ->whereHas('nabadatWallet',
            fn($query)=>$query
                ->where('total_pulses', '>', 0)
                ->where('updated_at', Carbon::parse(Carbon::now()->addDays(-11))->format('Y-m-d'))
            )->get();
            ScheduleFcm::UserReminderFcm($scheduleFcmNabadatElevenDays, $users);
        }
        //end nabadat usage reminder
        return Command::SUCCESS;
    }
}
