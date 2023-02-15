<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

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
}
