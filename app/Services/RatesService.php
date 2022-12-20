<?php

namespace App\Services;

use App\Models\Center;
use App\Models\Device;
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
        $model = match ($data['ratable_type']) {
            Rate::PRODUCT => Product::find($data['ratable_id']),
            Rate::DEVICE => Device::find($data['ratable_id']),
            Rate::CENTER => Center::find($data['ratable_id']),
        };
        if (isset($model))
            $model->rates()->create([
                'user_id' => $data['user_id'],
                'rate_number' => $data['rate_number'],
                'comment' => $data['comment']
            ]);
        $model->load('rates');
        return $this->refreshItemRate($model);

    }

    private function refreshItemRate(Product|Device $model): bool
    {

        $totalItemRate = $model->rates->sum('rate_number');
        $ratesCount = $model->rates->count();
        $finalRate = round(($totalItemRate / $ratesCount), 1, PHP_ROUND_HALF_EVEN);
        $model->update([
            'rate' => $finalRate
        ]);
        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $rate = Rate::with('ratable')->find($id);
        //TODO refresh rate  of ratable model after delete
        $rate->delete();
        return true;
    }
}
