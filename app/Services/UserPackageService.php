<?php

namespace App\Services;

use App\Models\Package;
use App\Models\UserPackage;
use App\QueryFilters\UserPackagesFilter;

use Illuminate\Database\Eloquent\Builder;
class UserPackageService extends BaseService
{

    public function listing(array $filters = [], array $withRelation = []): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(where_condition: $filters, withRelation: $withRelation)->cursorPaginate($perPage);
    }

    public function queryGet(array $where_condition = [], $withRelation = []): Builder
    {
        $userPackages = UserPackage::query()->with($withRelation);
        return $userPackages->filter(new UserPackagesFilter($where_condition));
    }
    public function store(array $data = [])
    {
        $package = Package::find($data['package_id']);
        if($data['payment_method'] == '1')//1 equal to cash status you can change it for the correct value
        {
            return UserPackage::create([
                'user_id'             => $data['user_id'],
                'package_id'          => $data['package_id'],
                'center_id'           => 1,//$package->center,
                'num_nabadat'         => $package->num_nabadat,
                'price'               => $package->price,
                'discount_percentage' => 15,//$package->discount_percentage,
                'payment_method'      => $data['payment_method'],
                'payment_status'      => 1, // this is the status of cash
                'usage_status'        => 1,//this is the first status for new user packages
                'used'                => 0,
                'remaining'           => $package->num_nabadat
            ]);
        }else
        {
            // pay using credit and then create user package
            $paymentStatus = 1;//$paymentStatus = payments::paycredit();
            return UserPackage::create([
                'user_id'             => $data['user_id'],
                'package_id'          => $data['package_id'],
                'center_id'           => $package->center,
                'num_nabadat'         => $package->num_nabadat,
                'price'               => $package->price,
                'discount_percentage' => $package->discount_percentage,
                'payment_method'      => $data['payment_method'],
                'payment_status'      => $paymentStatus, 
                'usage_status'        => '1',//this is the first status for new user packages
                'used'                => 0,
                'remaining'           => $package->num_nabadat
            ]);    
        }

    }

    public function update(int $id, array $data)
    {
        $userPackage = UserPackage::find($id);
        $package = Package::find($userPackage->package_id);
        if ($userPackage) {
             $userPackage->update($data);
             $userPackage->update([
                'payment_status' => $data['payment_status'], 
                'usage_status'   => $data['usage_status'],//this is the first status for new user packages
                'used'           => $data['used'],
                'remaining'      => $data['remaining']
            ]);
             return  $userPackage;
        }
        return false;
    }
    public function find(int $id, array $with = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $userPackage = UserPackage::with($with)->find($id);
        if ($userPackage)
            return $userPackage;
        return false;
    }

    public function delete(int $id)
    {
        $userPackage = UserPackage::find($id);
        if ($userPackage) {
            return $userPackage->delete();
        }
        return false;
    } //end of delete

}
