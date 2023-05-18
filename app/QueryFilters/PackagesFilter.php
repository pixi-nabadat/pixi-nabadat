<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;
use App\Enum\PackageStatusEnum;

class PackagesFilter extends QueryFilter
{

    /**
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        parent::__construct($params);
    }

    public function in_duration()
    {
        return $this->builder->active();
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active', $term);
    }

    public function status($term)
    {
        return $this->builder->where('status', $term);
    }

    public function center_id($term)
    {
        return $this->builder->where('center_id', $term);
    }
}
