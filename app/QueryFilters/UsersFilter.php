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

}
