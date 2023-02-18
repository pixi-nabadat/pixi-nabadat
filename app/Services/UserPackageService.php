<?php

namespace App\Services;

use App\Enum\PaymentStatusEnum;
use App\Exceptions\NotFoundException;
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

    /**
     * @throws NotFoundException
     */
    public function update(int $id, array $data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|array
    {
        $userPackage = $this->find(id:$id,with:['user','package'] );
        if (!$userPackage)
            throw new NotFoundException(trans('lang.offers_not_found'));
      $userPackage->update([
            'payment_status' => $data['payment_status'],
        ]);
     return  $userPackage->refresh();
    }

    public function create(array $data =[]){
        return UserPackage::create($data);
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
        return $userPackage->delete();

    } //end of delete

}
