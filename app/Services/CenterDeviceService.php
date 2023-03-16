<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Exceptions\NotFoundException;
use App\Models\Center;
use App\Models\CenterDevice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class CenterDeviceService extends BaseService
{

    public function __construct(public CenterDevice $model)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function findCenterById(int $id, array $withRelations = [], $columns = ['*'])
    {
        $center = Center::with($withRelations)->find($id);
        if (!$center)
            throw new NotFoundException(trans('lang.center_not_found'));
        return $center;

    }

    /**
     * @throws NotFoundException
     */
    public function find(int $id , array $withRelations=[])
    {
        $center_device =  $this->model->query()->with($withRelations)->find($id);
        if (!$center_device)
            throw new NotFoundException(trans('lang.center_not_found'));
        return $center_device ;

    }
    //get center devices api

    /**
     * @throws NotFoundException
     */
    public function getAllCenterDevices($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|array
    {
        return $this->model->query()->with(['attachments', 'device'])->where('center_id', $id)->get();
    }

    public function store(array $data = [])
    {
        $center = $this->findCenterById(id: $data['center_id']);
        $data['auto_service'] = isset($data['auto_service']) ? 1 : 0;
        $center->devices()->syncWithoutDetaching([$data['device_id'] => Arr::except($data, ['device_id', 'primary_image', 'gallery'])]);
        $center_devices = $this->model->query()->with(['attachments', 'device'])->where('center_id', $center->id)->where('device_id', $data['device_id'])->first();
        if (isset($data['primary_image'])) {
            $fileData = FileService::saveImage(file: $data['primary_image'], path: 'uploads/center_devices', field_name: 'primary_image');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $center_devices->storeAttachment($fileData);
        }
        if (isset($data['gallery']) && is_array($data['gallery']))
            foreach ($data['gallery'] as $image) {
                $fileData = FileService::saveImage(file: $image, path: 'uploads/center_devices', field_name: 'gallery');
                $fileData['type'] = ImageTypeEnum::GALARY;
                $center_devices->storeAttachment($fileData);
            }
        $center->refresh();
        $center_devices->refresh();
        return $center_devices;
    }

    /**
     * @throws NotFoundException
     */
    public function delete(int $id)
    {
        $centerDevice = $this->find($id);
        if (!$centerDevice)
            throw new NotFoundException(trans('lang.center_device_not_found'));
        $centerDevice->delete();
        $centerDevice->deleteAttachments();
        return true;
    }

    public function update($id, $data)
    {
        $centerDevice = $this->find($id);
        if (!$centerDevice)
            return false;
        $data['auto_service'] = isset($data['auto_service']) ? 1 : 0;
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        if (isset($data['primary_image'])) {
            $centerDevice->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['primary_image'], path: 'uploads\center_devices', field_name: 'primary_image');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $centerDevice->storeAttachment($fileData);
        }
        if (isset($data['gallery']) && is_array($data['gallery']))
            foreach ($data['gallery'] as $image) {
                $fileData = FileService::saveImage(file: $image, path: 'uploads\center_devices', field_name: 'gallery');
                $fileData['type'] = ImageTypeEnum::GALARY;
                $centerDevice->updateAttachment($fileData);
            }
        $centerDevice->update($data);
        $centerDevice->refresh();
        return $centerDevice;
    } //end of update


    /**
     * @throws NotFoundException
     */
    public function supportAutoService($id): bool
    {
        $centerDevice = $this->find($id);
        $centerDevice->auto_service = !$centerDevice->auto_service;
        return $centerDevice->save();
    }//end of is_support_auto_service

    public function status($id): bool
    {
        $centerDevice = $this->find($id);
        $centerDevice->is_active = !$centerDevice->is_active;
        return $centerDevice->save();

    }//end of status

}
