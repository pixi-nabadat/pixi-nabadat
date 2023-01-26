<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Enum\PaymentMethodEnum;
use App\Exceptions\NotFoundException;
use App\Models\Center;
use App\Models\User;
use App\QueryFilters\CentersFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CenterService extends BaseService
{

    public function listing(array $filters = [], array $withRelation = []): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(where_condition: $filters, withRelation: $withRelation)->cursorPaginate($perPage);
    }

    public function queryGet(array $where_condition = [], $withRelation = []): Builder
    {
        $centers = Center::query()->with($withRelation);
        return $centers->filter(new CentersFilter($where_condition));
    }

    public function getAll(array $where_condition = [], array $withRelations = [])
    {
        $centers = $this->queryGet($where_condition, $withRelations);
        return $centers->get();
    }

    /**
     * @throws NotFoundException
     */
    public function store(array $data = [])
    {
        DB::beginTransaction();
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['is_support_auto_service'] = isset($data['is_support_auto_service']) ? 1 : 0;
        $data['featured'] = isset($data['featured']) ? 1 : 0;
        
        $center_data = $this->prepareCenterData($data);
        $center = Center::create($center_data);
        if (!$center)
           throw new NotFoundException(trans('lang.center_not_created'));
        if (isset($data['logo']))
        {
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads\centers', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $center->storeAttachment($fileData);
        }
        if (isset($data['images']) && is_array($data['images']))
            foreach ($data['images'] as $image) {
                $fileData = FileService::saveImage(file: $image, path: 'uploads/centers', field_name: 'images');
                $fileData['type'] = ImageTypeEnum::GALARY;
                $center->storeAttachment($fileData);
            }
        $userData = $this->prepareUserData($data);
        $center->user()->create($userData);
        DB::commit();
        return $center;
    }

    private function prepareUserData($data)
    {
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => json_encode($data['phones']),
            'user_name' => $data['user_name'],
            'password' => bcrypt($data['password']),
            'type' => User::CENTERADMIN,
            'is_active' => $data['is_active'] ,
            'location_id' => $data['location_id'],
        ];
    }

    private function prepareCenterData($data): array
    {
        return [
            'is_support_auto_service'=>$data['is_support_auto_service'],
            'featured'=>$data['featured'],
            'phones'=>$data['phones'],
            'address' => $data['address'],
            'description' => $data['description'],
            'avg_waiting_time'=>$data['avg_waiting_time'],
            'support_payments'=> $data['support_payments'],
            'app_discount'=>$data['app_discount'],
            'lat'=>$data['lng'],
            'lng'=>$data['lng'],
            'google_map_url'=>$data['google_map_url'],
        ];
    }

    public function update(int $centerId, array $data): bool
    {
        $center = $this->find($centerId);
        if (!$center)
            throw new NotFoundException(trans('lang.center_not_found'));

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['is_support_auto_service'] = isset($data['is_support_auto_service']) ? 1 : 0;
        $data['featured'] = isset($data['featured']) ? 1 : 0;
        
        if (isset($data['logo']))
        {
            $center->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads\centers', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $center->storeAttachment($fileData);
        }
        if (isset($data['images']) && is_array($data['images']))
            foreach ($data['images'] as $image) {
                $fileData = FileService::saveImage(file: $image, path: 'uploads/centers', field_name: 'images');
                $fileData['type'] = ImageTypeEnum::GALARY;
                $center->storeAttachment($fileData);
            }
        $centerData = $this->prepareCenterData($data);
        $center->update($centerData);

        $userData = $this->prepareUserData($data);
        if(!isset($userData['password']))
            $userData['password'] = $center->user->password;
        $center->user()->update($userData);
        return true;
    }

    public function find($id, $with = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $center = Center::with($with)->find($id);
        if (!$center)
            throw new NotFoundException(trans('lang.center_not_found'));
        return $center;
    }

    public function changeStatus($id)
    {
        $center = $this->find($id);
        $center->is_active = !$center->is_active;
        return $center->save();
    }

    public function changeSupportAutoServiceStatus($id)
    {
        $center = $this->find($id);
        $center->is_support_auto_service = !$center->is_support_auto_service;
        return $center->save();
    }

    public function delete($id): bool
    {
        $center = $this->find($id);
        $center->deleteAttachments();
        return $center->delete();
    }

    public function featured($id): bool
    {
        $center = $this->find($id);
        $center->featured = !$center->featured;
        return $center->save();
    }
}
