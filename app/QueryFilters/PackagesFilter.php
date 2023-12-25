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

    public function center_phone($term)
    {
        return $this->builder->whereHas('center.user', function ($query) use ($term) {
            $query->where('phone', $term);
        });
    }

    public function number_pulses($term)
    {
        return $this->builder->where('num_nabadat', $term);
    }

    public function price($term)
    {
        return $this->builder->where('price', $term);
    }

    public function start_date($term)
    {
        return $this->builder->where('start_date', $term);
    }

    public function end_date($term)
    {
        return $this->builder->where('end_date', $term);
    }

    public function discount_percentage($term)
    {
        return $this->builder->where('discount_percentage', $term);
    }
    public function keyword($term)
    {
        return $this->builder->where('name', 'like', '%'.$term.'%');
    }

    public function governorate_id($term)
    {
        if (isset($term))
            return $this->builder->whereHas('center', function ($query) use ($term) {
                $query->whereHas('user', function($query) use ($term){
                    $query->whereHas('location', function ($query) use ($term) {
                        $query->where('parent_id', $term);
                    });
                });
            });
    }

    public function location_id($term)
    {
        if (isset($term))
            return $this->builder->whereHas('center', function ($query) use ($term) {
                $query->whereHas('user', function($query) use ($term){
                    $query->where('location_id', $term);
                });
            });
    }
}
