<?php

namespace App\Services;

use App\Models\Package;
use App\Models\UserPackage;
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
        $userPackages = UserPackage::query();
        return $userPackages->filter(new UserPackagesFilter($where_condition));
    }

    public function store($data)
    {
        $package = Package::find($data['package_id']);
        if($data['payment_method'] == 'cash')
        {
            return UserPackage::create([
                'user_id'             => $data['user_id'],
                'package_id'          => $data['package_id'],
                'center_id'           => $package->center,
                'num_nabadat'         => $package->num_nabadat,
                'price'               => $package->price,
                'discount_percentage' => $package->discount_percentage,
                'payment_method'      => $data['payment_method'],
                'payment_status'      => 1, // this is the status of cash
                'usage_status'        => 1,//this is the first status for new user packages
                'used'                => 0,
                'remaining'           => $package->num_nabadat
            ]);
        }else
        {
            /**
             * pay using credit and then create user package
             */
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
        
    } //end of store

    public function find($id)
    {

        $userPackage = UserPackage::find($id);
        if ($userPackage)
            return $userPackage;
        return false;

    } //end of find

    public function delete($id)
    {
        $userPackage = UserPackage::find($id);
        if ($userPackage) {
            return $userPackage->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        $userPackage = UserPackage::find($id);
        $package = Package::find($userPackage->package_id);
        if ($userPackage) {
             $userPackage->update([
                'payment_status'      => $data['payment_status'], 
                'usage_status'        => '1',//this is the first status for new user packages
                'used'                => 0,
                'remaining'           => $package->num_nabadat
            ]);
             return  $userPackage;
        }
        return false;
    } //end of update
}
