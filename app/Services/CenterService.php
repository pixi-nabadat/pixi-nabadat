<?php

namespace App\Services;


use App\Models\Center;
use App\QueryFilters\CentersFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\GetListCenterResource;
class CenterService extends BaseService
{


    public function queryGet(array $where_condition = [],$with=[]): Builder
    {
        $centers = Center::query()->with('Location');
        return $centers->filter(new CentersFilter($where_condition));
    }

    public function getAll(array $where_condition = [])
    {
        $centers = $this->queryGet($where_condition);
        $centers = $centers->cursorPaginate(10);
        return GetListCenterResource::collection($centers);
    }

    public function store(array $centerData = [])
    {
        $center = Center::create($centerData);
        if ($center)
            return true;
        return false;
    }

    public function getCenterById($id)
    {
        return Center::find($id);
    }

    public  function update(int $centerId, array $centerData)
    {
        $center = $this->getCenterById($centerId);
        $center->update($centerData);
        return true;
    }

    public function changeStatus($id)
    {
        $center = Center::find($id);
        $center->is_active = !$center->is_active;
        $center->save();
    }

    public function delete($id): bool
    {
        $center = $this->getCenterById($id);
        if ($center)
            return $center->delete();
        return false;
    }
}
