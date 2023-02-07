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
        $centerDevice = $this->find($data['device_id']);
        if(!$centerDevice)
            $centerDevice = CenterDevice::create($data);
        else
            $centerDevice->update($data);
        return $centerDevice;
    }

    public function find(int $id)
    {

        $centerDevice = CenterDevice::find($id);
        if ($centerDevice)
            return $centerDevice;
        return false;

    } //end of update

    public function delete(int $id)
    {
        $centerDevice = $this->find($id);
        if(!$centerDevice)
        {
            return false;   
        }else{
            $centerDevice->delete();
            return true;
        }
    }
}
