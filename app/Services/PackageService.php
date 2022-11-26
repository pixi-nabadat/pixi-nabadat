<?php

namespace App\Services;

use App\Models\package;
use App\Models\User;
use App\QueryFilters\packagesFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class packageService extends BaseService
{

    public function getAll(array $where_condition = [])
    {
        $packages = $this->queryGet($where_condition);
        return $packages->get();
    }

    public function queryGet(array $where_condition = [],array $withRelation=[]): Builder
    {
        $packages = package::query()->with($withRelation);
        return $packages->filter(new packagesFilter($where_condition));
    }

    public function store($data)
    {
        $data['is_active'] = isset($data['is_active'])  ? 1 :  0;
        return package::create($data);
    } //end of store

    public function find($id,$withRelation=[])
    {
        $package = package::with($withRelation)->find($id);
        if ($package)
            return $package;
        return false;
    } //end of find

    public function delete($id)
    {
        $package = package::find($id);
        if ($package) {
            return $package->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        $data['is_active'] = isset($data['is_active'])  ? 1 :  0;
        $package = package::find($id);
        if ($package) {
            $package->update($data);
        }
        return false;
    } //end of update

    public function status($id)
    {
        $package = $this->find($id);
        $package->is_active = !$package->is_active;
        return $package->save();

    }//end of status
}
