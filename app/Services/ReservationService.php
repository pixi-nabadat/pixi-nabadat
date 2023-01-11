<?php

namespace App\Services;

use App\Exceptions\StatusNotEquelException;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Center;
use App\QueryFilters\ReservationsFilter;
use Exception;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
class ReservationService extends BaseService
{

    public function listing(array $filters = [], array $withRelation = []): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(where_condition: $filters, withRelation: $withRelation)->cursorPaginate($perPage);
    }

    public function queryGet(array $where_condition = [], $withRelation = []): Builder
    {
        $reservations = Reservation::query()->with($withRelation);
        return $reservations->filter(new ReservationsFilter($where_condition));
    }
    public function store(array $data = [])
    {
        $data['qr_code']     = uniqid();
        $reservation = Reservation::create($data);

        $reservation->history()->create([
            'status' =>Reservation::PENDING,
        ]);

        $reservation->refresh();
        if (!$reservation)
            return false;
        return $reservation->load('center','user','history');
    }

    public function update(int $reservationId, array $reservationData): bool
    {
        $reservation = $this->find($reservationId);
        if ($reservation) {
            $reservation->update($reservationData);
        }
        return false;
    }
    public function find($qrCode, $with = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $reservation = Reservation::with($with)->where('qr_code', $qrCode)->first();
        if ($reservation)
            return $reservation;
        return false;
    }
}
