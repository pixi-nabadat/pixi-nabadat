<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class DevicesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active', $term);
    }

    public function keyword($term)
    {
        return $this->builder->where('name', 'like', '%'.$term.'%');
    }

    public function rate($term)
    {
        return $this->builder->whereHas('center', function ($query) use ($term) {
            $query->where('center_devices.rate', $term);
        });
    }
    public function auto_service($term)
    {
        return $this->builder->whereHas('center', function ($query) use ($term) {
            $query->where('center_devices.auto_service', $term);
        });
    }

    public function governorate_id($term)
    {
        if (isset($term))
            return $this->builder->whereHas('center.user', function ($query) use ($term) {
                $query->whereHas('location', function ($query) use ($term) {
                    $query->where('parent_id', $term);
                });
            });
    }

}
