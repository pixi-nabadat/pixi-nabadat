<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class RatesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function status($term)
    {
        return $this->builder->where('status',$term);
    }

    public function rate_number($term)
    {
        return $this->builder->where('rate_number', $term);
    }

}
