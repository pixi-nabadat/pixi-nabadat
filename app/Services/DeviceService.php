<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use App\Models\Device;
use App\QueryFilters\DevicesFilter;
use Illuminate\Database\Eloquent\Builder;

class DeviceService extends BaseService
{

    public function getAll(array $where_condition = [])
    {
        $Devices = $this->queryGet($where_condition);
        return $Devices->get();
    }

    public function queryGet(array $where_condition = []): Builder
    {
        $Devices = Device::query();
        return $Devices->filter(new DevicesFilter($where_condition));
    }

    public function store($data)
    {
        $image = $data['image'];

        // if($image){
            
        // }

        return Device::create($data);
    } //end of store

    public function find($id)
    {
        $device = Device::find($id);
        if ($device)
            return $device;
        return false;
    }//end of find

    public function delete($id)
    {
        $device=Device::find($id);
        if ($device)
            return $device->delete();
        return false;
    }//end of delete

    public function update($id , $data)
    {
        $image = $data['image'];

        // if($image){
            
        // }
        
        $device=Device::find($id);
        if ($device)
            $device->update($data);
        return false;
    }//end of update
}
