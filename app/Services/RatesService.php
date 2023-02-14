<?php

namespace App\Services;

use App\Models\Center;
use App\Models\CenterDevice;
use App\Models\Product;
use App\Models\Rate;

class RatesService extends BaseService
{


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
                'status'      => 1
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

    /**
     * @param int $id
     * @return void
     */
    public function destroy(int $id): bool
    {
        $rate = Rate::find($id);
        if(!$rate)
            return false;
        $ratableType = $rate->ratable_type;
        $model       = $ratableType::find($rate->ratable_id);
        $rate->delete();
        $this->refreshItemRate($model);
        return true;
    }
}
