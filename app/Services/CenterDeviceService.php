<?php

namespace App\Services;

use App\Models\CenterDevice;
use App\QueryFilters\CenterDevicesFilter;
use Illuminate\Database\Eloquent\Builder;

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

    public function update(int $id, array $data = []): bool
    {
        $centerDevice = $this->find($id);
        if ($centerDevice) {
            $data['is_support_auto_service'] = isset($data['is_support_auto_service']) ? 1 : 0;
            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
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

    public function supportAutoService($id): bool
    {
        $centerDevice = $this->find($id);
        $centerDevice->is_support_auto_service = !$centerDevice->is_support_auto_service;
        return $centerDevice->save();

    }//end of is_support_auto_service

    public function status($id): bool
    {
        $centerDevice = $this->find($id);
        $centerDevice->is_active = !$centerDevice->is_active;
        return $centerDevice->save();

    }//end of status

}
