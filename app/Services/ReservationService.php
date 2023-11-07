<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Reservation;
use App\Models\User;
use App\QueryFilters\ReservationsFilter;
use Illuminate\Database\Eloquent\Builder;

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
        $user = User::find($data['customer_id']);
        if(!$user)
            throw new NotFoundException(trans('lang.user_not_found'));
        $oldRerservations = $user->reservation()->whereHas('latestStatus', function($query){
            $query->whereNotIn('status', [Reservation::COMPLETED, Reservation::Expired, Reservation::CANCELED]);
        });
        if($oldRerservations->count())
            throw new NotFoundException(trans('lang.there_is_another_reservation'));
        $data['qr_code'] = uniqid();
        $reservation = Reservation::create($data);

        $reservation->history()->create([
            'status' => Reservation::PENDING,
            'added_by' => auth()->user()->id ?? null,
        ]);

        $reservation->refresh();
        return $reservation->load('center.user:id,center_id,name,phone', 'latestStatus');
    }

    /**
     * @throws NotFoundException
     */
    public function update(int $reservationId, array $reservationData=[]): bool
    {
        $reservation = $this->findById($reservationId);
        if (!$reservation)
            throw new NotFoundException(trans('lang.reservation_not_found'));
        return $reservation->update($reservationData);
    }

    /**
     * @throws NotFoundException
     */
    public function findById($id, $with = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $reservation = Reservation::with($with)->find($id);
        if (!$reservation)
            throw new NotFoundException(trans('lang.reservation_not_found'));
        return $reservation;
    }

    public function destroy($id)
    {
        $reservation = $this->findById($id);
        return $reservation->delete();
    } //end of delete

    /**
     * @throws NotFoundException
     */
    public function findByQrCode($qr_code, $with = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $reservation = Reservation::query()->where('qr_code', $qr_code)->with($with)->first();
        if (!$reservation)
            throw new NotFoundException(trans('lang.reservation_not_found'));
        return $reservation;
    }
}