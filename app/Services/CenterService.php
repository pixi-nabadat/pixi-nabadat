<?php

namespace App\Services;


use App\Models\Center;
use App\Models\Location;
use App\Models\User;
use App\QueryFilters\CentersFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CenterService extends BaseService
{


    public function queryGet(array $where_condition = []): Builder
    {
        $centers = Center::query();
        return $centers->filter(new CentersFilter($where_condition));
    }

    public function getAll(array $where_condition = [])
    {
        $centers = $this->queryGet($where_condition);
        return $centers->get();
    }
    public function getAllDoctors()
    {
        $doctors = User::where('type', User::DOCTORTYPE)->get();
        return response()->json($doctors);
    }

    public function store(array $centerData = [], array $doctorIds =[])
    {
        $centerId = Center::create($centerData)->id;
        $centerObj = $this->getCenterById($centerId);
        $centerObj->doctors()->sync($doctorIds);
        return true;
    }

    public function getCenterById($id)
    {
        return Center::where('id', $id)->first();
    }

    public  function update(int $centerId, array $centerData, array $doctorIds)
    {
        $centerObj = $this->getCenterById($centerId);
        $centerId = Center::where('id', $centerId)->update($centerData);
        $centerObj->doctors()->sync($doctorIds);
        return true;
    }

    public function delete($id): bool
    {
        $center = Center::find($id);
        if ($center)
            return $center->delete();
        return false;
    }
}
