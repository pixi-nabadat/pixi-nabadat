<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Package;
use App\QueryFilters\PackagesFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CenterPackageService extends BaseService
{

    public function __construct(public Package $model)
    {
    }

    public function getAll(array $where_condition = [], array $withRelations = []): \Illuminate\Database\Eloquent\Collection|array
    {
        $packages = $this->queryGet($where_condition, $withRelations);
        return $packages->get();
    }

    public function queryGet(array $where_condition = [], array $withRelation = []): Builder
    {
        $packages = $this->model->orderBy('status')->with($withRelation);
        return $packages->filter(new PackagesFilter($where_condition));
    }

    public function listing(array $where_condition = [], $withRelation = [], $perPage = 10)
    {
        return $this->queryGet($where_condition, $withRelation)->cursorPaginate($perPage);
    }

    public function store($data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1:0;
        $package = $this->model->create($data);
        if (isset($data['image'])) {
            $fileData = FileService::saveImage(file: $data['image'], path: 'uploads/packages');
            $package->storeAttachment($fileData);
        }

        return true;

    } //end of store

    public function delete($id)
    {
        $package = $this->find($id);
        $package->deleteAttachments();
        return $package->delete();

    } //end of find

    /**
     * @throws NotFoundException
     */
    public function find($id, $withRelation = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $package = $this->model->query()->with($withRelation)->find($id);
        if (!$package)
            throw new NotFoundException(trans('lang.package_not_fount'));
        return $package;
    } //end of delete

    public function update($id, $data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $package = $this->find($id);
        if (isset($data['image'])) {
            $package->deleteAttachments();
            $fileData = FileService::saveImage(file: $data['image'], path: 'uploads/packages', field_name: 'image');
            $package->storeAttachment($fileData);
        }
        $package->update($data);
        $package->save();
        return true;
    } //end of update

    public function status($id): bool
    {
        $package = $this->find($id);
        $package->is_active = !$package->is_active;
        return $package->save();

    }//end of status
}
