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

    public function user_phone($term)
    {
        return $this->builder->whereHas('user', function ($query) use ($term) {
            $query->where('phone', $term);
        });
    }

    public function shipping_fees($term)
    {
        return $this->builder->where('shipping_fees', $term);
    }
    
    public function sub_total($term)
    {
        return $this->builder->where('sub_total', $term);
    }

    public function grand_total($term)
    {
        return $this->builder->where('grand_total', $term);
    }

    public function coupon_discount($term)
    {
        return $this->builder->where('coupon_discount', $term);
    }

    public function payment_method($term)
    {
        return $this->builder->where('payment_method', $term);
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
