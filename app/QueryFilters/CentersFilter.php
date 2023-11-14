<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class CentersFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function id($term)
    {
        return $this->builder->where('id', $term);
    }

    public function featured($term)
    {
        return $this->builder->where('featured', $term);
    }

    public function auto_service($term)
    {
        return $this->builder->where('is_support_auto_service', $term);
    }

    public function primary_phone($term)
    {
        return $this->builder->whereHas('user', function ($query) use ($term) {
            $query->where('phone', $term);
        });
    }


    public function is_active($term)
    {
        return $this->builder->whereHas('user', function ($query) use ($term) {
            $query->where('is_active', $term);
        });
    }

    public function name($term)
    {
        return $this->builder->whereHas('user', function ($query) use ($term) {
            $query->where('name', 'LIKE', "%$term%");
        });
    }

    public function location_id($term)
    {
        if (isset($term))
            return $this->builder->whereHas('user', function ($query) use ($term) {
                $query->where('location_id', $term);
            });
    }

    public function governorate_id($term)
    {
        if (isset($term))
            return $this->builder->whereHas('user', function ($query) use ($term) {
                $query->whereHas('location', function ($query) use ($term) {
                    $query->where('parent_id', $term);
                });
            });
    }

    public function appointment_id($term)
    {
        return $this->builder->whereHas('appointments',fn($query)=>$query->where('day_of_week',$term));
    }

    public function keyword($term)
    {
        return $this->builder->where('name', 'like', '%'.$term.'%');
    }

    public function rate($term)
    {
        return $this->builder->where('rate', $term);
    }

}
