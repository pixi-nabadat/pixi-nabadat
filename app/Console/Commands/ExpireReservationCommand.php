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
        $currentDate = Carbon::today()->format('Y-m-d H:i:s');

        $reservations = Reservation::query()->whereHas('latestStatus',fn($query)=>$query->where('status','!=',Reservation::CONFIRMED))->where('check_date','<',$currentDate)->get();
        foreach($reservations as $reservation)
        {
            $reservationCheckDate = Carbon::parse($reservation->check_date)->format('Y-m-d H:i:s');
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
