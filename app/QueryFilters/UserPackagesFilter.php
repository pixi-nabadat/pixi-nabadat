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
        return $this->builder->where('user_type',$term);
    }

    public function user_id($term)
    {
        return $this->builder->where('user_id',$term);
    }

    public function center_id($term)
    {
        return $this->builder->where('center_id',$term);
    }

}
