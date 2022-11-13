<?php

namespace App\Services;

use App\Models\userPackage;
use App\QueryFilters\UserPackagesFilter;
use Illuminate\Database\Eloquent\Builder;

class UserPackageService extends BaseService
{

    public function getAll(array $where_condition = [])
    {
        $userPackages = $this->queryGet($where_condition);
        return $userPackages->get();
    }

    public function queryGet(array $where_condition = []): Builder
    {
        $userPackages = userPackage::query();
        return $userPackages->filter(new UserPackagesFilter($where_condition));
    }

    public function store($data)
    {
        return userPackage::create($data);

    } //end of store

    public function find($id)
    {

        $userPackage = userPackage::find($id);
        if ($userPackage)
            return $userPackage;
        return false;

    } //end of find

    public function delete($id)
    {
        $userPackage = userPackage::find($id);
        if ($userPackage) {
            return $userPackage->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        $userPackage = userPackage::find($id);
        if ($userPackage) {
             $userPackage->update($data);
             return  $userPackage;
        }
        return false;
    } //end of update
}
