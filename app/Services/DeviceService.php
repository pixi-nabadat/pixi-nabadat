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

        $device = Device::create($data);
        if (!$device)
            return false ;

        if (isset($data['images'])&&is_array($data['images']))
            foreach ($data['images'] as $image)
            {
                $fileData = FileService::saveImage(file: $image,path: 'uploads\devices');
                $device->storeAttachment($fileData);
            }
    } //end of store

    public function find($id,$with=[])
    {
        $device = Device::with($with)->find($id);
        if ($device)
            return $device;
        return false;
    } //end of find

    public function delete($id)
    {
        $device = $this->find($id);
        if ($device) {
            $device->deleteAttachments();
            return $device->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        $device = Device::find($id);
        if ($device) {
            if (isset($data['images'])&&is_array($data['images']))
                foreach ($data['images'] as $image)
                {
                    $fileData = FileService::saveImage(file: $image,path: 'uploads\devices');
                    $device->storeAttachment($fileData);
                }
            $device->update($data);
        }
        return false;

    } //end of update
}
