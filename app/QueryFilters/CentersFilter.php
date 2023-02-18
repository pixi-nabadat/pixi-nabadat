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

    public function appointment_id($term)
    {
        return $this->builder->whereHas('appointments',fn($query)=>$query->where('day_of_week',$term));
    }

}
