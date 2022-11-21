<?php

namespace App\Services;

use App\Models\Address;
use App\QueryFilters\AddressesFilter;
use Illuminate\Database\Eloquent\Builder;

class AddressService extends BaseService
{

    public function getAll(array $where_condition = [])
    {
        $addresses = $this->queryGet($where_condition);
        return $addresses->get();
    }

    public function queryGet(array $where_condition = []): Builder
    {
        $addresses = Address::query();
        return $addresses->filter(new AddressesFilter($where_condition));
    }

    public function store($data)
    {
        return Address::create($data);

    } //end of store

    public function find($id)
    {

        $address = Address::find($id);
        if ($address)
            return $address;
        return false;

    } //end of find

    public function delete($id)
    {
        $address = Address::find($id);
        if ($address) {
            return $address->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        $address = Address::find($id);
        if ($address) {
             $address->update($data);
             return  $address;
        }
        return false;
    } //end of update
}
