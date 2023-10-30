<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;
use App\Models\Slider;

class SlidersFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active', $term);
    }

    public function type($term)
    {
        return $this->builder->where('type', $term);
    }

    public function start_date($term)
    {
        return $this->builder->where('start_date', '<',$term);
    }

    public function end_date($term)
    {
        return $this->builder->where('end_date', '>',$term);
    }

    public function location_id($term)
    {
        return $this->builder->whereHas('center.user',fn($query)=>$query->where('location_id',$term));
    }

    public function start_date_equal($term)
    {
        return $this->builder->where('start_date', $term);
    }

    public function end_date_equal($term)
    {
        return $this->builder->where('end_date', $term);
    }

    public function center_id($term)
    {
        return $this->builder->where('type', Slider::CENTER)->where('sliderable_id', $term);
    }

    public function product_id($term)
    {
        return $this->builder->where('type', Slider::PRODUCT)->where('sliderable_id', $term);
    }

    public function order($term)
    {
        return $this->builder->where('order', $term);
    }

    public function in_duration()
    {
        return $this->builder->active();
    }
}
