<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class CategoriesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }
}
