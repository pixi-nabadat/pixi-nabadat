<?php

namespace App\Services;

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

    public function store(array $data = [])
    {
        DB::beginTransaction();
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['is_support_auto_service'] = isset($data['is_support_auto_service']) ? 1 : 0;
        $data['featured'] = isset($data['featured']) ? 1 : 0;
        $center = Center::create($data);
        if (!$center)
            return false;
        if (isset($data['images']) && is_array($data['images']))
            foreach ($data['images'] as $image) {
                $fileData = FileService::saveImage(file: $image, path: 'uploads/centers');
                $center->storeAttachment($fileData);
            }
        DB::commit();
        return $center;
    }

    public function update(int $centerId, array $centerData): bool
    {
        $center = $this->find($centerId);
        if ($center) {
            if (isset($centerData['images']) && is_array($centerData['images']))
                foreach ($centerData['images'] as $image) {
                    $fileData = FileService::saveImage(file: $image, path: 'uploads/centers');
                    $center->storeAttachment($fileData);
                }
            $center->update($centerData);
        }
        return false;
    }

    public function find($id, $with = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $center = Center::with($with)->find($id);
        if ($center)
            return $center;
        return false;
    }

    public function changeStatus($id)
    {
        $center = Center::find($id);
        $center->is_active = !$center->is_active;
        return $center->save();
    }

    public function changeSupportAutoServiceStatus($id)
    {
        $center = Center::find($id);
        $center->is_support_auto_service = !$center->is_support_auto_service;
        return $center->save();
    }

    public function delete($id): bool
    {
        $center = $this->find($id);
        if ($center) {
            $center->deleteAttachments();
            return $center->delete();
        }
        return false;
    }

    public function featured($id): bool
    {
        $center = $this->find($id);
        $center->featured = !$center->featured;
        return $center->save();

    }
}
