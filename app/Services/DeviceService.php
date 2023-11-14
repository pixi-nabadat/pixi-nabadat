<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
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

    public function queryGet(array $where_condition = [], array $withRelation = []): Builder
    {
        $Devices = Device::query()->with($withRelation);
        return $Devices->filter(new DevicesFilter($where_condition));
    }

    public function store(array $data = [])
    {
        $data['is_active'] = isset($data['is_active'])  ?  1 :  0;
        $device = Device::create($data);
        if (!$device)
            return false ;
        if (isset($data['logo']))
        {
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads/devices', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $device->storeAttachment($fileData);
        }
        if (isset($data['images'])&&is_array($data['images']))
            foreach ($data['images'] as $image)
            {
                $fileData = FileService::saveImage(file: $image,path: 'uploads/devices', field_name: 'images');
                $fileData['type'] = ImageTypeEnum::GALARY;
                $device->storeAttachment($fileData);
            }
        return $device ;
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
        $data['is_active'] = isset($data['is_active'])  ?  1 :  0;
        if ($device) {
            if (isset($data['logo']))
            {
                $device->deleteAttachmentsLogo();
                $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads/devices', field_name: 'logo');
                $fileData['type'] = ImageTypeEnum::LOGO;
                $device->storeAttachment($fileData);
            }
            if (isset($data['images'])&&is_array($data['images']))
            foreach ($data['images'] as $image)
            {
                $fileData = FileService::saveImage(file: $image,path: 'uploads/devices', field_name: 'images');
                $fileData['type'] = ImageTypeEnum::GALARY;
                $device->storeAttachment($fileData);
            }
            $device->update($data);
        }
        return false;

    } //end of update

    public function changeStatus($id)
    {
        $device = $this->find($id);
        $device->is_active = !$device->is_active;
        return $device->save();
    }//end of changeStatus
}
