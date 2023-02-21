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
        cache()->forget('home-api');
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
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
        cache()->forget('home-api');
        $coupon = $this->find($id);
        if ($coupon) {
            return $coupon->delete();
        }
        return false;
    } //end of delete

    public function update(int $id, array $data = []): bool
    {
        cache()->forget('home-api');
        $coupon = $this->find($id);
        if ($coupon) {
            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $coupon->update($data);
        }
        return false;
    } //end of update

    public function status($id): bool
    {
        $coupon = $this->find($id);
        $coupon->is_active = !$coupon->is_active;
        return $coupon->save();

    }//end of status
}
