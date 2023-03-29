<?php

namespace App\Console\Commands;

use App\Enum\FcmEventsNames;
use App\Models\ScheduleFcm;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PointsRemindercommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'points-reminder:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Points reminder before expiration';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //start points expire reminder

        $scheduleFcmForPoints  = ScheduleFcm::query()
        ->where('is_active', 1)
        ->whereIn('trigger', [FcmEventsNames::$EVENTS['EXPIRE_POINTS_BEFORE_1'],FcmEventsNames::$EVENTS['EXPIRE_POINTS_BEFORE_3'],FcmEventsNames::$EVENTS['EXPIRE_POINTS_BEFORE_7']])
        ->get();

        $scheduleFcmPointsOneDay = $scheduleFcmForPoints->where('trigger',FcmEventsNames::$EVENTS['EXPIRE_POINTS_BEFORE_1'])->first();
        
        $scheduleFcmPointsthreeDays = $scheduleFcmForPoints->where('trigger',FcmEventsNames::$EVENTS['EXPIRE_POINTS_BEFORE_3'])->first();
        
        $scheduleFcmPointsSevenDays = $scheduleFcmForPoints->where('trigger',FcmEventsNames::$EVENTS['EXPIRE_POINTS_BEFORE_7'])->first();

        $usersFilters = ['points_expire_date' => null];
        
        if($scheduleFcmPointsOneDay)
        {
            $userPointsOneDayRemain = app()->make(UserService::class)->queryGet(where_condition: $usersFilters, withRelation: [])
            ->where('points_expire_date', Carbon::parse(Carbon::now()->addDay())->format('Y-m-d'))->get();
            ScheduleFcm::UserReminderFcm($scheduleFcmPointsOneDay, $userPointsOneDayRemain);
        }
        if($scheduleFcmPointsthreeDays)
        {
            $userPointsThreeDaysRemain = app()->make(UserService::class)->queryGet(where_condition: $usersFilters, withRelation: [])
            ->where('points_expire_date', Carbon::parse(Carbon::now()->addDays(4))->format('Y-m-d'))->get();
            ScheduleFcm::UserReminderFcm($scheduleFcmPointsthreeDays, $userPointsThreeDaysRemain);
        }
        if($scheduleFcmPointsSevenDays)
        {
            $userPointsSevenDaysRemain = app()->make(UserService::class)->queryGet(where_condition: $usersFilters, withRelation: [])
            ->where('points_expire_date', Carbon::parse(Carbon::now()->addDays(8))->format('Y-m-d'))->get();
            ScheduleFcm::UserReminderFcm($scheduleFcmPointsSevenDays, $userPointsSevenDaysRemain);
        }
        //end points expire reminder
        
        return Command::SUCCESS;
    }
}
