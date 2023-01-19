<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;
use Illuminate\Support\Arr;

class UsersFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function type($term)
    {
        return $this->builder->where('type',$term);
    }

    public function type_in($term)
    {
        return $this->builder->whereIn('type',Arr::wrap($term));
    }

    public function users($term)
    {

        return $this->builder->whereIn('id', Arr::wrap($term));
    }

    public function location_id($term)
    {
        return $this->builder->where('location_id',$term);
    }

    public function locations($term)
    {
        return $this->builder->whereIn('location_id',Arr::wrap($term));
    }

    public function where_has_reservation($term)
    {
        return $this->builder->whereHas('reservation',fn($query)=>$query->whereIn('reservations.center_id',Arr::wrap($term)));
    }

    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

}
