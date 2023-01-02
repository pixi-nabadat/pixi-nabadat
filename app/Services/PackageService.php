<?php

namespace App\Services;

use App\Models\package;
use App\QueryFilters\packagesFilter;
use Illuminate\Database\Eloquent\Builder;

class PackageService extends BaseService
{

    public function getAll(array $where_condition = [], array $withRelations = [])
    {
        $packages = $this->queryGet($where_condition, $withRelations);
        return $packages->get();
    }

    public function queryGet(array $where_condition = [], array $withRelation = []): Builder
    {
        $packages = package::query()->with($withRelation);
        return $packages->filter(new packagesFilter($where_condition));
    }

    public function store($data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $package = package::create($data);
        if (isset($data['image'])){
            $fileData = FileService::saveImage(file: $data['image'],path: 'uploads\packages');
            $package->storeAttachment($fileData);
        }
            
    } //end of store

    public function delete($id)
    {
        $package = $this->find($id);
        if (!$package)
            return false;
        return $package->delete();

    } //end of find

    public function find($id, $withRelation = [])
    {
        $package = package::with($withRelation)->find($id);
        if ($package)
            return $package;
        return false;
    } //end of delete

    public function update($id, $data): bool|int
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $package = $this->find($id);
        if (!$package)
            return false;
        if (isset($data['image'])){

            $fileData = FileService::saveImage(file: $data['image'],path: 'uploads\packages');
            $package->storeAttachment($fileData);
        }
        return $package->update($data);
    } //end of update

    public function status($id): bool
    {
        $package = $this->find($id);
        $package->is_active = !$package->is_active;
        return $package->save();

    }//end of status
}
