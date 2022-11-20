<?php

namespace App\Services;

use App\Models\CancelReason;
use App\QueryFilters\CancelReasonsFilter;
use Illuminate\Database\Eloquent\Builder;

class CancelReasonService extends BaseService
{



    public function getAll(array $where_condition = [], array $withRelation=[])
    {
        return $this->queryGet($where_condition,$withRelation)->get();

    }

    public function queryGet(array $where_condition = [],$with=[]): Builder
    {
        $cancelReasons = CancelReason::query()->with($with);
        return $cancelReasons->filter(new CancelReasonsFilter($where_condition));
    }

    public function store($data)
    {
        $data['is_active'] = isset($data['is_active'])  ?  1 :  0;
        return $cancelReason = CancelReason::create($data);
    } //end of store

    public function find($id)
    {

        $cancelReason = CancelReason::find($id);
        if ($cancelReason)
            return $cancelReason;
        return false;

    } //end of find

    public function delete($id): bool
    {
        $cancelReason = $this->find($id);
        if ($cancelReason) {
            return $cancelReason->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data): bool
    {
        $data['is_active'] =  isset($data['is_active'])  ? 1 : 0;
        $cancelReason =$this->find($id);
        if ($cancelReason) {
            $cancelReason->update($data);
        }
        return false;
    } //end of update

    public function changeStatus($id)
    {
        $cancelReason = $this->find($id);
        $cancelReason->is_active = !$cancelReason->is_active;
        return $cancelReason->save();

    }//end of changeStatus
}
