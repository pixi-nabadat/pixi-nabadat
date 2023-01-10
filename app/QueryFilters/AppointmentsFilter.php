<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class AppointmentsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function center_id($term)
    {
        return $this->builder->where('center_id',$term);
    }
}
