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

    public function coupon_for($term)
    {
        return $this->builder->where('coupon_for',$term);
    }

    public function start_date($term)
    {
        return $this->builder->where('start_date',$term);
    }

    public function end_date($term)
    {
        return $this->builder->where('end_date',$term);
    }

    public function allowed_usage($term)
    {
        return $this->builder->where('allowed_usage',$term);
    }

    public function min_buy($term)
    {
        return $this->builder->where('min_buy',$term);
    }

    public function discount($term)
    {
        return $this->builder->where('discount',$term);
    }

    public function added_by($term)
    {
        return $this->builder->where('added_by',$term);
    }

    public function code($term)
    {
        return $this->builder->where('code',$term);
    }

    public function in_period()
    {
        $date = Carbon::now(config('app.africa_timezone'))->format('Y-m-d');
        return  $this->builder->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date);
    }
}
