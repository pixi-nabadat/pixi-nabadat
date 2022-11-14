<?php

namespace App\Services;

use App\Models\CancelReason;
use App\QueryFilters\CancelReasonFilter;
use Illuminate\Database\Eloquent\Builder;

class CancelReasonService extends BaseService
{



    public function getAll(array $where_condition = [], array $withRelation=[])
    {
        return $this->queryGet($where_condition,$withRelation)->get();

    }

    public function queryGet(array $where_condition = [],$with=[]): Builder
    {
        $cancelReasons = cancelReason::query()->with($with);
        return $cancelReasons->filter(new CancelReasonFilter($where_condition));
    }

    public function store($data)
    {
        $data['is_active'] = isset($data['is_active'])  ?  1 :  0;
        return $cancelReason = cancelReason::create($data);
    } //end of store

    public function find($id)
    {

        $cancelReason = cancelReason::find($id);
        if ($cancelReason)
            return $cancelReason;
        return false;

    } //end of find

    public function delete($id)
    {
        $cancelReason = CancelReason::find($id);
        if ($cancelReason) {
            return $cancelReason->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        isset($data['is_active'])  ?   $data['is_active']=1 : $data['is_active']= 0;
        $cancelReason = cancelReason::find($id);
        if ($cancelReason) {
            $cancelReason->update($data);
        }
        return false;
    } //end of update

    public function changeStatus($id)
    {
        $cancelReason = CancelReason::find($id);
        $cancelReason->is_active = !$cancelReason->is_active;
        return $cancelReason->save();

    }//end of changeStatus
}
