<?php

namespace Database\Seeders;

use App\Models\Center;
use App\Models\Reservation;
use App\Models\User;
use App\Services\ReservationService;
use Illuminate\Database\Seeder;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = User::where('type', User::CUSTOMERTYPE)->first();
        $center = Center::first();
        $data = [
            'customer_id' => $customer->id,
            'center_id' => $center->id,
            'check_date' => '2023-03-26',
            'qr_code' => uniqid()
        ];

        $reservation = new ReservationService();
        $reservation = $reservation->store($data);
    }
}
