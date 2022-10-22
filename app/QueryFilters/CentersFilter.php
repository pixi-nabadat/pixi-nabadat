<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class CentersFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function name($term)
    {
        return $this->builder->where('name',$term);
    }

    public function location_id($term)
    {
        return $this->builder->where('location_id',$term);
    }

}
