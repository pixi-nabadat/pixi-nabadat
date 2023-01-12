<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class ProductsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function id($term)
    {
        return $this->builder->where('id',$term);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function featured($term)
    {
        return $this->builder->where('featured',$term);
    }

    public function category_id($term)
    {
        return $this->builder->where('category_id',$term);
    }

    public function type($term)
    {
        return $this->builder->where('type',$term);
    }
}
