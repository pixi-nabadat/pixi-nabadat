<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class LocationsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function depth($term)
    {
        return $this->builder->withDepth()->having('depth', $term);
    }

    public function parent($term)
    {
        return $this->builder->where('parent_id', $term);
    }

}
