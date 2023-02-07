<?php

namespace App\Services;

use App\Models\CenterDevice;
use App\QueryFilters\CenterDevicesFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CenterDeviceService extends BaseService
{

    public function getAll(array $where_condition = [], array $withRelation = [])
    {
        return $this->queryGet($where_condition, $withRelation)->get();
    }

    public function queryGet(array $where_condition = [], $withRelation = []): Builder
    {
        $centerDevices = CenterDevice::query()->with($withRelation);
        return $centerDevices->filter(new CenterDevicesFilter($where_condition));
    }

    public function store(array $data = [])
    {
        $data['center_id'] = Auth::user()->center_id;
        $centerDevice = CenterDevice::create($data);
        return $centerDevice;
    }

    public function update(int $id, array $data = []): bool
    {
        $centerDevice = $this->find($id);
        if ($centerDevice) {
            $centerDevice->update($data);
        }
        return false;
    } //end of find

public function find(int $id)
    {

        $centerDevice = CenterDevice::find($id);
        if ($centerDevice)
            return $centerDevice;
        return false;

    } //end of update
}
