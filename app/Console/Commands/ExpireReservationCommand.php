<?php

namespace App\Console\Commands;

use App\Events\PushEvent;
use App\Models\FcmMessage;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireReservationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'change expired reservation status to expired';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = Carbon::now()->setTimezone('Africa/Cairo');

        $reservations = Reservation::query()->whereDate('check_date','<',$currentDate)->whereHas('latestStatus', function ($query) {
            $query->whereNotIn('status', [Reservation::COMPLETED, Reservation::Expired, Reservation::CANCELED]);
        })->get();
        foreach($reservations as $reservation)
        {
            $reservationCheckDate = Carbon::parse($reservation->check_date);
            if($currentDate->gt($reservationCheckDate))
            {
                $reservation->history()->create([
                    'status' => Reservation::Expired
                ]);
                $reservation->save();
                event(new PushEvent($reservation, FcmMessage::CHANGE_RESERVATION_STATUS));
            }
        }
        return Command::SUCCESS;
    }
}
