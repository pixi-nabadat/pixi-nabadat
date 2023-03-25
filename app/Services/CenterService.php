<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Exceptions\NotFoundException;
use App\Models\Center;
use App\Models\User;
use App\QueryFilters\CentersFilter;
use Illuminate\Database\Eloquent\Builder;
class CenterService extends BaseService
{

    public function __construct(public  Center $model)
    {
    }

    public function listing(array $filters = [], array $withRelation = []): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(where_condition: $filters, withRelation: $withRelation)->cursorPaginate($perPage);
    }

    public function queryGet(array $where_condition = [], $withRelation = []): Builder
    {
        $centers = $this->model->query()->active()->with($withRelation)->withCount('devices');
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
        $data['is_active'] = isset($data['is_active']) ?? 0;
        $data['is_support_auto_service'] = isset($data['is_support_auto_service']) ?? 0;
        $data['featured'] = isset($data['featured']) ??  0;
        
        $center_data = $this->prepareCenterData($data);
        $center = $this->model->create($center_data);
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
        return $center;
    }

    private function prepareUserData($data)
    {
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['primary_phone'],
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
            'phones'=>isset($data['phones']) ? array_filter($data['phones']):null,
            'address' => $data['address'],
            'description' => $data['description'],
            'avg_waiting_time'=>$data['avg_waiting_time'],
            'support_payments'=> $data['support_payments'],
            'pulse_price'=>$data['pulse_price'],
            'pulse_discount'=>isset($data['pulse_discount']) ? $data['pulse_discount']:null,
            'app_discount'=>isset($data['app_discount']) ? $data['app_discount']:null,
            'lat'=>$data['lng'],
            'lng'=>$data['lng'],
            'google_map_url'=>$data['google_map_url'],
        ];
    }

    public function update(int $centerId, array $data): bool
    {
        $center = $this->find($centerId);
        $data['is_active'] = isset($data['is_active']) ?? 0;
        $data['is_support_auto_service'] = isset($data['is_support_auto_service']) ?? 0;
        $data['featured'] = isset($data['featured']) ?? 0;
        
        if (isset($data['logo']))
        {
            $center->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads/centers', field_name: 'logo');
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
        $center = $this->model->with($with)->withCount('devices')->find($id);
        if (!$center)
            throw new NotFoundException(trans('lang.center_not_found'));
        return $center;
    }

    public function changeStatus($id)
    {
//        todo check you pass id of user not center
        $user = User::find($id);
        $user->is_active = !$user->is_active;
        return $user->save();
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
