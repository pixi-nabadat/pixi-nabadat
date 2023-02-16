<?php

namespace App\Services;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Settlement;
use App\Models\Package;
use App\Models\UserPackage;
use App\QueryFilters\UserPackagesFilter;

use Carbon\Carbon;
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

    /**
     * @throws NotFoundException
     */
    public function update(int $id, array $data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|array
    {
        $userPackage = UserPackage::with('center')->find($id);
        if (!$userPackage)
            throw new NotFoundException(trans('lang.offers_not_found'));
       $is_updated =  $userPackage->update([
            'payment_status' => $data['payment_status'],
        ]);
     return  $userPackage;
    }

    public function create(array $data =[]){
        return UserPackage::create($data);
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
