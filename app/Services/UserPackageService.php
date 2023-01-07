<?php

namespace App\Services;

use App\Enum\PaymentStatusEnum;
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

    public function update(int $id, array $data)
    {
        $userPackage = UserPackage::find($id);
        $package = Package::find($userPackage->package_id);
        if ($userPackage) {
             $userPackage->update($data);
             $userPackage->update([
                'payment_status' => $data['payment_status'], 
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
            $paymentStatus = $userPackage->payment_status;
            if($paymentStatus != PaymentStatusEnum::UNPAID)
                return ['status'=>false, 'message'=> trans('lang.operation_success')];
            return $userPackage->delete();
        }
        return ['status'=>false, 'message'=> trans('lang.not_found')];
    } //end of delete

}
