<?php

namespace App\Console\Commands;

use App\Enum\FcmEventsNames;
use App\Models\Reservation;
use App\Models\ScheduleFcm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
        //start reservations check date reminder
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
            $reservationsOneDayRemain = Reservation::query()->whereHas('latestStatus',fn($query)=>$query->where('status',Reservation::CONFIRMED))
            ->where('check_date', Carbon::parse(Carbon::now()->addDays(2))->format('Y-m-d'))->get();
    
            ScheduleFcm::ReservationCheckDateRemiderFcm($scheduleFcmOneDay, $reservationsOneDayRemain);
        }
        if($scheduleFcmOneDay)
        {
            $reservationsTwoDaysRemain = Reservation::query()->whereHas('latestStatus',fn($query)=>$query->where('status',Reservation::CONFIRMED))
            ->where('check_date', Carbon::parse(Carbon::now()->addDays(3))->format('Y-m-d'))->get();

            ScheduleFcm::ReservationCheckDateRemiderFcm($scheduleFcmTwoDays, $reservationsTwoDaysRemain);
        }
        //end reservation check date reminder

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
            ScheduleFcm::UserPointsExpireReminderFcm($scheduleFcmPointsOneDay, $userPointsOneDayRemain);
        }
        if($scheduleFcmPointsthreeDays)
        {
            $userPointsThreeDaysRemain = User::query()
            ->where('points_expire_date', '!=', null)
            ->where('points_expire_date', Carbon::parse(Carbon::now()->addDays(4))->format('Y-m-d'))->get();
            ScheduleFcm::UserPointsExpireReminderFcm($scheduleFcmPointsthreeDays, $userPointsThreeDaysRemain);
        }
        if($scheduleFcmPointsSevenDays)
        {
            $userPointsSevenDaysRemain = User::query()
            ->where('points_expire_date', '!=', null)
            ->where('points_expire_date', Carbon::parse(Carbon::now()->addDays(8))->format('Y-m-d'))->get();
            ScheduleFcm::UserPointsExpireReminderFcm($scheduleFcmPointsthreeDays, $userPointsSevenDaysRemain);
        }
        //end points expire reminder
        return Command::SUCCESS;
    }
}
