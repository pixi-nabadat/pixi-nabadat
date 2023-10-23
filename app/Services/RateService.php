<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Center;
use App\Models\CenterDevice;
use App\Models\Product;
use App\Models\Rate;
use App\QueryFilters\RatesFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RateService extends BaseService
{

    public function queryGet(array $filters = [] , array $withRelation = []) :builder
    {
        $rates = Rate::query()->with($withRelation);
        return $rates->filter(new RatesFilter($filters));
    }

    public function listing(array $filters = [] , array $withRelation =[] ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(filters: $filters,withRelation: $withRelation)->cursorPaginate($perPage);
    }

    /**
     * @throws NotFoundException
     */
    public function find(int $rateId , array $withRelations = []): Rate|Model|bool
    {
        $rate =  Rate::with($withRelations)->find($rateId);
        if (!$rate)
           throw new NotFoundException(trans('lang.rate_no_found'));
        return $rate;
    }

    /**
     * deleting rate
     * @param int $id
     * @throws NotFoundException
     * @return bool
     */
    public function destroy($id): bool
    {
        $rate = $this->find($id);
        $ratableType = $rate->ratable_type;
        $model       = $ratableType::find($rate->ratable_id);
        $rate->delete();
        $this->refreshItemRate($model);
        return true;
    }

    public function status($id)
    {
        $rate = $this->find($id);
        $rate->status = !$rate->status;
        return $rate->save();

    }//end of status

    // ///////////////////////
    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data)
    {
        $model = match ((int)$data['ratable_type']) {
            Rate::PRODUCT        => Product::find($data['ratable_id']),
            Rate::CENTER_DEVICE  => CenterDevice::find($data['ratable_id']),
            Rate::CENTER         => Center::find($data['ratable_id']),
        };
        if (isset($model))
            $model->rates()->updateOrCreate(['user_id'     => $data['user_id']],[
                'user_id'     => $data['user_id'],
                'rate_number' => $data['rate_number'],
                'comment'     => $data['comment'],
                'status'   => 1
            ]);
        $this->refreshItemRate($model);
        return $model->load(['rates'=>fn($rates)=>$rates->orderBy('id','desc')]);

    }

    private function refreshItemRate(Product|CenterDevice|Center $model): void
    {

        $totalItemRate = $model->rates->sum('rate_number');
        $ratesCount    = $model->rates->count();
        $finalRate = 0;
        if($ratesCount > 0)
            $finalRate = round(($totalItemRate / $ratesCount), 1, PHP_ROUND_HALF_EVEN);
        $model->update([
            'rate' => $finalRate
        ]);
    }

}
