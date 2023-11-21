<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\StatusNotEquelException;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Center;
use App\Models\ScheduleFcm;
use App\QueryFilters\ReservationsFilter;
use App\QueryFilters\ScheduleFcmFilter;
use Carbon\Carbon;
use Exception;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
class ScheduleFcmService extends BaseService
{

    public function listing(array $filters = [], array $withRelation = []): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(where_condition: $filters, withRelation: $withRelation)->cursorPaginate($perPage);
    }

    public function queryGet(array $where_condition = [], $withRelation = []): Builder
    {
        $scheduleFcm = ScheduleFcm::query()->with($withRelation);
        return $scheduleFcm->filter(new ScheduleFcmFilter($where_condition));
    }
    public function store(array $data = [])
    {
        $data['is_active']  = isset($data['is_active'])? 1:0;
        $scheduleFcm = ScheduleFcm::create($data);
        return $scheduleFcm;
    }

    /**
     * @throws NotFoundException
     */
    public function update(int $id, array $data): bool
    {
        $scheduleFcm = $this->find($id);
        if (!$scheduleFcm)
            throw new NotFoundException(trans('lang.schedule_fcm_not_found'));
        $data['is_active']  = isset($data['is_active'])? 1:0;
        return $scheduleFcm->update($data);
    }

    /**
     * @throws NotFoundException
     */
    public function find($id, $with = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $scheduleFcm = ScheduleFcm::with($with)->find($id);
        if (!$scheduleFcm)
            throw new NotFoundException(trans('lang.schedule_fcm_not_found'));
        return $scheduleFcm;
    }

    public function delete(int $id)
    {
        $scheduleFcm = ScheduleFcm::find($id);
        if(!$scheduleFcm)
            throw new NotFoundException(trans('lang.not_found'));
        return $scheduleFcm->delete();
    }
    public function status($id): bool
    {
        $scheduleFcm = $this->find($id);
        $scheduleFcm->is_active = !$scheduleFcm->is_active;
        return $scheduleFcm->save();

    }//end of status
}