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

    public function total_center_dues($term)
    {
        $this->builder->where('total_center_dues', $term);
    }

    public function total_nabadat_dues($term)
    {
        $this->builder->where('total_nabadat_dues', $term);
    }

    public function completed_date($term)
    {
        $this->builder->where('completed_date', $term);
    }

    public function status($term)
    {
        $this->builder->where('status', $term);
    }
}
