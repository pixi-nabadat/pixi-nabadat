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
        return $this->builder->where('user_id',$term);
    }

    public function status_id($term)
    {
        return $this->builder->whereHas('history',function ($query){
            $query->where('id',1);
        });
    }
}
