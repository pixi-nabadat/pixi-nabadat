<?php

namespace App\Services;

use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\UserPackage;
use App\Models\User;
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

    /**
     * @throws NotFoundException
     */
    public function update(int $id, array $data=[]): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|array
    {
        $userPackage = $this->find(id:$id,with:['user','package'] );
        if (!$userPackage)
            throw new NotFoundException(trans('lang.offers_not_found'));
        $ongoingPackage = $userPackage->user->package->where('status', UserPackageStatusEnum::ONGOING)->first();
        if(!$ongoingPackage)
            $data['status'] = $data['payment_status'] == PaymentStatusEnum::PAID ? UserPackageStatusEnum::ONGOING: UserPackageStatusEnum::PENDING;
        else
            $data['status'] = $data['payment_status'] == PaymentStatusEnum::PAID ? UserPackageStatusEnum::READYFORUSE: UserPackageStatusEnum::PENDING;
        $data['remain'] = $data['num_nabadat'];
        $is_updated =  $userPackage->update($data);
        /**
         * TODO
         * add finance code here
         */
        return  $userPackage->refresh();
    }

    public function create(array $data =[]){
        return UserPackage::create($data);
    }

    public function store(array $data)
    {
        $user = User::find($data['user_id']);
        if(!$user)
            throw new NotFoundException(trans('lang.user_not_found'));
        $userPackages = $user->package->where('status', UserPackageStatusEnum::ONGOING)->first();
        if(!$userPackages)
            $data['status'] = $data['payment_status'] == PaymentStatusEnum::PAID ? UserPackageStatusEnum::ONGOING: UserPackageStatusEnum::PENDING;
        else
            $data['status'] = $data['payment_status'] == PaymentStatusEnum::PAID ? UserPackageStatusEnum::READYFORUSE: UserPackageStatusEnum::PENDING;
        $data['remain'] = $data['num_nabadat'];
        $userPackage = UserPackage::create($data);
        /**
         * TODO
         * add user package financial code here
         */
        return  $userPackage;
    }


    /**
     * @throws NotFoundException
     */
    public function find(int $id, array $with = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $userPackage = UserPackage::with($with)->find($id);
        if (!$userPackage)
            throw new NotFoundException(trans('user package not found'));
        return $userPackage;
    }

    public function delete(int $id)
    {
        $userPackage = $this->find($id);
        if(!$userPackage)
            throw new NotFoundException(trans('lang.user_package_not_found'));
        $paymentStatus = $userPackage->payment_status;
        if($paymentStatus != PaymentStatusEnum::UNPAID)
            throw new NotFoundException(trans('lang.not_allowed'));
        return $userPackage->delete();

    } //end of delete

}
