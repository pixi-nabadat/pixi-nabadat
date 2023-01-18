<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class UsersFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function type($term)
    {
        return $this->builder->where('type',$term);
    }

    public function type_in($term)
    {
        return $this->builder->whereIn('type',$term);
    }

    public function location_id($term)
    {
        return $this->builder->where('location_id',$term);
    }


    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

}
