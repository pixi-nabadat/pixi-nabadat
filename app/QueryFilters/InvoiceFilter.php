<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class InvoiceFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function type($term)
    {
        return $this->builder->where('status',$term);
    }

    public function center_id($term)
    {
        $this->builder->where('center_id',$term);
    }
}
