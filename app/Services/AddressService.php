<?php

namespace App\Services;

use App\Models\Address;
use App\QueryFilters\AddressesFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Relationship;

class AddressService extends BaseService
{

    public function getAll(array $where_condition = [], array $relations = [])
    {
        $addresses = $this->queryGet($where_condition, $relations);
        return $addresses->get();
    }

    public function queryGet(array $where_condition = [], array $with = []): Builder
    {
        $addresses = Address::query()->with($with);
        return $addresses->filter(new AddressesFilter($where_condition));
    }

    public function store(array $data)
    {
        return Address::create($data);

    } //end of store

    public function find(int $id)
    {

        $address = Address::find($id);
        if ($address)
            return $address;
        return false;

    } //end of find

    public function delete(int $id)
    {
        $address = $this->find($id);
        if ($address) {
            return $address->delete();
        }
        return false;
    } //end of delete

    public function update(int $id, array $data)
    {
        $address = $this->find($id);
        if ($address) {
             $address->update($data);
             return  $address;
        }
        return false;
    } //end of update

    public function setDefualt(int $id)
    {

        $address = $this->find($id);
        Address::where('user_id',$address->user_id)->update(['is_default'=>0]);
        $address->update(['is_default'=>1]);
        return true ;

    }//end of  setDefualt
}
