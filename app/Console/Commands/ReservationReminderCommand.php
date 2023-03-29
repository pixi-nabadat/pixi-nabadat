<?php

namespace App\Console\Commands;

use App\Enum\FcmEventsNames;
use App\Models\Reservation;
use App\Models\ScheduleFcm;
use App\Models\User;
use App\Services\ReservationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReservationReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation-reminder:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send reservation fcm notification for users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {        
        //start reservations check date reminder
        $reservationFilter = ['status'=>Reservation::CONFIRMED];

        $withRelations = ['user','center.user.location','latestStatus'] ;

        $scheduleFcmForReservation  = ScheduleFcm::query()
        ->where('is_active', 1)
        ->whereIn('trigger', [FcmEventsNames::$EVENTS['ONE_DAY_BEFORE_RESERVATION'],FcmEventsNames::$EVENTS['TWO_DAYS_BEFORE_RESERVATION']])
        ->get();

        $scheduleFcmReservationBeforeOneDay = $scheduleFcmForReservation->where('trigger',FcmEventsNames::$EVENTS['ONE_DAY_BEFORE_RESERVATION'])->first();

        $scheduleFcmReservationBeforeTwoDays = $scheduleFcmForReservation->where('trigger',FcmEventsNames::$EVENTS['TWO_DAYS_BEFORE_RESERVATION'])->first();

        if($scheduleFcmReservationBeforeOneDay)
        {
            $reservationsOneDayReminder = app()->make(ReservationService::class)->queryGet(where_condition: $reservationFilter,withRelation: $withRelations)
            ->where('check_date',  Carbon::now()->addDay()->format('Y-m-d'))->get();
            ScheduleFcm::ReservationCheckDateReminderFcm($scheduleFcmReservationBeforeOneDay, $reservationsOneDayReminder);
        }
        if($scheduleFcmReservationBeforeTwoDays)
        {
            $reservationsTwoDaysReminder =app()->make(ReservationService::class)->queryGet(where_condition: $reservationFilter,withRelation: $withRelations)
            ->where('check_date',  Carbon::now()->addDays(2)->format('Y-m-d'))->get();
            ScheduleFcm::ReservationCheckDateReminderFcm($scheduleFcmReservationBeforeTwoDays, $reservationsTwoDaysReminder);
        }
        //end reservation check date reminder
        return Command::SUCCESS;
    }
}
