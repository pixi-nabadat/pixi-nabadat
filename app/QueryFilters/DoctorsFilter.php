<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class DoctorsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function title($term)
    {
        return $this->builder->where('name',$term);
    }

    public function center_id($term)
    {
        return $this->builder->where('center_id',$term);
    }

    public function phone($term)
    {
        return $this->builder->where('phone', $term);
    }

    public function age($term)
    {
        return $this->builder->where('age', $term);
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
