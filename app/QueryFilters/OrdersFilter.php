<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class OrdersFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function user_id($term)
    {
        return $this->builder->where('user_id', $term);
    }

    public function status($term)
    {
        return $this->builder->whereHas('history', function ($query) use ($term) {
            $query->where('status', $term);
        });
    }

    public function payment_status($term)
    {
        return $this->builder->where('payment_status', $term);
    }
}
