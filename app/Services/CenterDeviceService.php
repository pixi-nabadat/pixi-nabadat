<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Center;
use App\Models\CenterDevice;
use App\QueryFilters\CenterDevicesFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class CenterDeviceService extends BaseService
{


    //get center devices api
    public function getAllCenterDevices($id)
    {
        $center = Center::find($id);
        if(!$center)
            throw new NotFoundException(trans('lang.center_not_found'));
        return $center->devices;
    }
    public function store(array $data = [])
    {
        $center   = Center::find($data['center_id']);
        $data['auto_service'] = isset($data['auto_service']) ? 1 : 0;
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $center->devices()->syncWithoutDetaching([$data['device_id']=> Arr::except($data, 'device_id')]);
        return $center->devices;
    }

    /**
     * @throws NotFoundException
     */
    public function delete(int $id)
    {
        $centerId     = auth('sanctum')->user()->center_id;
        $center       = Center::find($centerId);
        $centerDevice = $center->devices()->detach($id);

        if (!$centerDevice)
            throw new NotFoundException(trans('lang.center_device_not_found'));
        return true;
    }

    public function supportAutoService($id): bool
    {
        $centerId = auth('sanctum')->user()->center_id;
        $center = Center::find($centerId);
        $centerDevice = $center->devices()->where('device_id', $id)->first();
        if(!$centerDevice)
            throw new NotFoundException(trans('lang.center_device_not_found'));
        $centerDevice->pivot->auto_service = !$centerDevice->pivot->auto_service;
        return $centerDevice->pivot->save();
    }//end of is_support_auto_service

    public function status($id): bool
    {
        $centerId = auth('sanctum')->user()->center_id;
        $center = Center::find($centerId);
        $centerDevice = $center->devices()->where('device_id', $id)->first();
        if(!$centerDevice)
            throw new NotFoundException(trans('lang.center_device_not_found'));
        $centerDevice->pivot->is_active = !$centerDevice->pivot->is_active;
        return $centerDevice->pivot->save();

    }//end of status

}
