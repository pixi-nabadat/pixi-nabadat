<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\User;
use App\QueryFilters\CouponsFilter;
use Illuminate\Database\Eloquent\Builder;

class CouponService extends BaseService
{

    public function getAll(array $where_condition = [])
    {
        $Coupons = $this->queryGet($where_condition);
        return $Coupons->get();
    }

    public function listing(array $filters = []): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet($filters)->cursorPaginate($perPage);
    }

    public function queryGet(array $where_condition = []): Builder
    {
        $coupons = Coupon::query();
        return $coupons->filter(new CouponsFilter($where_condition));
    }

    public function store(array $data = [])
    {
        return Coupon::create($data);
    } //end of store

    public function find(int $id)
    {

        $coupon = Coupon::find($id);
        if ($coupon)
            return $coupon;
        return false;

    } //end of find

    public function delete(int $id): bool
    {
        $coupon = $this->find($id);
        if ($coupon) {
            return $coupon->delete();
        }
        return false;
    } //end of delete

    public function update(int $id, array $data = []): bool
    {
        $coupon = $this->find($id);
        if ($coupon) {
            $coupon->update($data);
        }
        return false;
    } //end of update
}
