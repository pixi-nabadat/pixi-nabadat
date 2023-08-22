<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class UserPackagesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function id($term)
    {
        return $this->builder->where('id',$term);
    }
    public function user_type($term)
    {
        return $this->builder->where('type',$term);
    }

    public function user_id($term)
    {
        return $this->builder->where('user_id',$term);
    }

    public function center_id($term)
    {
        return $this->builder->where('center_id',$term);
    }

    public function number_pulses($term)
    {
        return $this->builder->where('num_nabadat',$term);
    }

    public function price($term)
    {
        return $this->builder->where('price',$term);
    }

    public function package_id($term)
    {
        return $this->builder->where('package_id',$term);
    }

    public function discount_percentage($term)
    {
        return $this->builder->where('discount_percentage',$term);
    }

    public function payment_method($term)
    {
        return $this->builder->where('payment_method',$term);
    }

    public function payment_status($term)
    {
        return $this->builder->where('payment_status',$term);
    }

    public function status($term)
    {
        return $this->builder->where('status',$term);
    }

    public function used($term)
    {
        return $this->builder->where('used',$term);
    
    }

    public function remain($term)
    {
        return $this->builder->where('remain',$term);
    }

}
