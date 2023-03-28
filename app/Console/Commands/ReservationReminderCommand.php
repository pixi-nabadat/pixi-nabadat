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
        $now = Carbon::now();

        $reservationFilter = ['status'=>Reservation::CONFIRMED];

        $withRelations = ['user','center.user.location','latestStatus'] ;

        $baseReservationBuilder = app()->make(ReservationService::class)->queryGet(where_condition: $reservationFilter,withRelation: $withRelations);

        $scheduleFcmForReservation  = ScheduleFcm::query()
        ->where('is_active', 1)
        ->whereIn('trigger', [FcmEventsNames::$EVENTS['ONE_DAY_BEFORE_RESERVATION'],FcmEventsNames::$EVENTS['TWO_DAYS_BEFORE_RESERVATION']])
        ->get();

        $scheduleFcmReservationBeforeOnDay = $scheduleFcmForReservation->where('trigger',FcmEventsNames::$EVENTS['ONE_DAY_BEFORE_RESERVATION'])->first();

        $scheduleFcmReservationBeforeTwoDays = $scheduleFcmForReservation->where('trigger',FcmEventsNames::$EVENTS['TWO_DAYS_BEFORE_RESERVATION'])->first();

        if($scheduleFcmReservationBeforeOnDay)
        {
            $reservationsOneDayReminder = $baseReservationBuilder->where('check_date', $now->addDay()->format('Y-m-d'))->get();
            ScheduleFcm::ReservationCheckDateRemiderFcm($scheduleFcmReservationBeforeOnDay, $reservationsOneDayReminder);
        }
        if($scheduleFcmReservationBeforeTwoDays)
        {
            $reservationsTwoDaysReminder =$baseReservationBuilder->where('check_date', $now->addDays(2)->format('Y-m-d'))->get();
            ScheduleFcm::ReservationCheckDateRemiderFcm($scheduleFcmReservationBeforeTwoDays, $reservationsTwoDaysReminder);
        }
        //end reservation check date reminder
        return Command::SUCCESS;
    }
}
