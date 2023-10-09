<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class ScheduleFcmFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function id($term)
    {
        return $this->builder->where('id',$term);
    }

    public function trigger($term)
    {
        return $this->builder->where('trigger',$term);
    }

    public function start_date($term)
    {
        return $this->builder->where('start_date',$term);
    }

    public function end_date($term)
    {
        return $this->builder->where('end_date',$term);
    }
    
    public function notification_via($term)
    {
        return $this->builder->where('notification_via',$term);
    }


    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function title($term)
    {
        return $this->builder->where('title',$term);
    }

    public function content($term)
    {
        return $this->builder->where('content',$term);
    }


}