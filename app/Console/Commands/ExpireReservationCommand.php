<?php

namespace App\Console\Commands;

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
        $currentDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::today());

        $reservations = Reservation::where('check_date','<',$currentDate)->get();
        foreach($reservations as $reservation)
        {
            $latestStatus = $reservation->latestStatus;
            if($latestStatus->getRawOriginal('status') != Reservation::CONFIRMED)
                continue;
            $reservationCheckDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($reservation->check_date));
            if($currentDate->gt($reservationCheckDate))
            {
                $reservation->history()->create([
                    'status' => Reservation::Expired
                ]);
                $reservation->save();
            }
        }
        return Command::SUCCESS;
    }
}
