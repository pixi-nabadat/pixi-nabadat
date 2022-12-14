<?php

namespace App\Services;

use App\Exceptions\StatusNotEquelException;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Center;
use App\Models\Product;
use App\QueryFilters\ReservationsFilter;
use Exception;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
class ProductEstimationService extends BaseService
{

    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data)//: bool
    {
        $product = Product::find($data['product_id']);
        $product->estimations()->create([
            'estimation'=>$data['estimation']
        ]);
        return $this->refreshProductEstimation($product);
    }

    private function refreshProductEstimation(Product $product): bool
    {
        $totalProductEstimation = $product->estimations->sum('estimation');
        $estimationsCount = $product->estimations->count();
        $finalEstimation = round(($totalProductEstimation / $estimationsCount), 1, PHP_ROUND_HALF_EVEN);
        $product->update([
            'estimation' => $finalEstimation
        ]);

        return true;
    }

}
