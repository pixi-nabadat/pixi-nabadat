<?php

namespace App\Services;

use App\Models\UserDeviceTokens;
use Illuminate\Support\Arr;

class UserDeviceService extends BaseService
{
    public function __construct(protected UserDeviceTokens $model)
    {

    }

    public function updateOrCreateDeviceToken(array $data = [])
    {
        return $this->model->updateOrCreate(
            Arr::only($data, ["device_token", 'user_id']),
            $data
        );
    }//end of changeStatus
}
