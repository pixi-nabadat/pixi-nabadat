<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Events\PushEvent;
use App\Exceptions\NotFoundException;
use App\Models\Center;
use App\Models\FcmMessage;
use App\Models\User;
use App\QueryFilters\CentersFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class CenterService extends BaseService
{

    public function __construct(public Center $model)
    {
    }

    public function listing(array $filters = [], array $withRelation = []): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(where_condition: $filters, withRelation: $withRelation)->cursorPaginate($perPage);
    }

    public function queryGet(array $where_condition = [], $withRelation = []): Builder
    {
        $centers = $this->model->query()->orderBy('created_at', 'desc')->active()->with($withRelation)->withCount('devices');
        return $centers->filter(new CentersFilter($where_condition));
    }

    public function getAll(array $where_condition = [], array $withRelations = []): \Illuminate\Database\Eloquent\Collection|array
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
        $data['featured'] = isset($data['featured']) ?? 0;

        $center_data = $this->prepareCenterData($data);
        $center = $this->model->create($center_data);
        if (!$center)
            throw new NotFoundException(trans('lang.center_not_created'));

        if (isset($data['logo'])) {
            $fileData = FileService::saveImage(file: $data['logo'], path: 'uploads/centers', field_name: 'logo');
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
        if (isset($data['profile_image'])) {
            $fileData = FileService::saveImage(file: $data['profile_image'], path: 'uploads/users', field_name: 'profile_image');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $center->user->storeAttachment($fileData);
        }
        event(new PushEvent($center, FcmMessage::DEAL_WITH_NEW_CENTER));
        return $center;
    }

    private function prepareUserData($data): array
    {
        return [
            'name' => Arr::get($data, 'user_name'),
            'email' => Arr::get($data, 'email'),
            'phone' => Arr::get($data, 'primary_phone'),
            'password' => Arr::get($data, 'password'),
            'type' => User::CENTERADMIN,
            'is_active' => Arr::get($data, 'is_active'),
            'location_id' =>Arr::get($data, 'location_id'),
        ];
    }

    private function prepareCenterData($data): array
    {
        return [
            'name' => Arr::get($data, 'name'),
            'is_support_auto_service' => Arr::get($data, 'is_support_auto_service'),
            'featured' =>Arr::get($data, 'featured'),
            'phones' => isset($data['phones']) ? array_filter($data['phones']) : null,
            'address' => Arr::get($data, 'address'),
            'description' => Arr::get($data, 'description'),
            'avg_waiting_time' => Arr::get($data, 'avg_waiting_time'),
            'support_payments' =>Arr::get($data, 'support_payments'),
            'pulse_price' => Arr::get($data, 'pulse_price'),
            'pulse_discount' => Arr::get($data, 'pulse_discount'),
            'app_discount' => Arr::get($data, 'app_discount'),
            'lat' => Arr::get($data, 'lat'),
            'lng' => Arr::get($data, 'lng'),
            'google_map_url' => Arr::get($data, 'google_map_url'),
            'status' => Arr::get($data, 'status'),
        ];
    }

    public function update(int $centerId, array $data): bool
    {
        $center = $this->find($centerId);
        $data['is_active'] = isset($data['is_active']) ?? 0;
        $data['is_support_auto_service'] = isset($data['is_support_auto_service']) ?? 0;
        $data['featured'] = isset($data['featured']) ?? 0;

        if (isset($data['profile_image'])) {
            $center->user->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['profile_image'], path: 'uploads/users', field_name: 'profile_image');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $center->user->storeAttachment($fileData);
        }

        if (isset($data['logo'])) {
            $center->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['logo'], path: 'uploads/centers', field_name: 'logo');
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
        if (!isset($userData['password']))
            $userData['password'] = $center->user->password;
        else
            $userData['password'] = bcrypt($userData['password']);
        $center->user()->update($userData);
        return true;
    }

    public function updateForApi(User $user, array $data): User
    {
        $centerData = $this->prepareCenterData($data);
        $user->center()->update($centerData);

        $userData = $this->prepareUserData($data);
        if (!isset($userData['password']))
            $userData = Arr::except($userData,'password');
        $user->update($userData);
        $user->refresh();
        return $user;
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
        $user = $this->find($id);
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
        $center->user->deleteAttachments();
        return $center->delete();
    }

    public function featured($id): bool
    {
        $center = $this->find($id);
        $center->featured = !$center->featured;
        return $center->save();
    }
}
