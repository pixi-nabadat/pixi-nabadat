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

    public function queryGet(array $where_condition = []): Builder
    {
        $Coupons = Coupon::query();
        return $Coupons->filter(new CouponsFilter($where_condition));
    }

    public function store($data)
    {
        return Coupon::create($data);
    } //end of store

    public function find($id)
    {

        $coupon = Coupon::find($id);
        if ($coupon)
            return $coupon;
        return false;

    } //end of find

    public function delete($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            return $coupon->delete();
        }
        return false;
    } //end of delete

    public function update($id, $data)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $coupon->update($data);
        }
        return false;
    } //end of update
}
