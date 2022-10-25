<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use App\Models\Device;
use App\QueryFilters\DevicesFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\AttachmentTrait;

class DeviceService extends BaseService
{

    use AttachmentTrait;
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

        if (isset($data['image']))
            $data['image'] = $this->storeAttachment($data['image'], 'uploads\device');
        else
            $data['image'] = 'default.png';

        return Device::create($data);
    } //end of store

    public function find($id)
    {
        $device = Device::find($id);
        if ($device)
            return $device;
        return false;
    } //end of find

    public function delete($id)
    {
        $device = Device::find($id);
        if ($device) {
            if ($device->image != 'default.png') {
                $this->removeAttachment($device->image, 'uploads/device/');
            }
            return $device->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        $device = Device::find($id);
        if ($device) {
            if (isset($data['image'])) {
                $this->removeAttachment($device->image, 'uploads/device/');
                $data['image'] = $this->storeAttachment($data['image'], 'uploads\device');
            }
            $device->update($data);
        }
        return false;

    } //end of update
}
