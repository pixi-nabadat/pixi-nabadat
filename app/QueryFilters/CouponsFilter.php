<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;
use App\Models\Coupon;
use Carbon\Carbon;
use function Termwind\render;

class CouponsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function in_period()
    {
        $date = Carbon::now(config('app.africa_timezone'))->format('Y-m-d');
        return  $this->builder->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date);
    }
}
