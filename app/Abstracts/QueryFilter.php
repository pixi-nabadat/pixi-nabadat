<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{

    protected $request;
    protected $builder;


    /**
     * QueryFilter constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->request = $params;
    }

    /**
     * Apply filters in request on resource if they are implemented in the resourceFilters class
     *
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (! method_exists($this, $name)) {
                continue;
            }

            if (is_array($value)) {
                $this->$name($value);
            } else {
                if (strlen($value)) {
                    $this->$name($value);
                }else{
                    $this->$name();
                }
            }
        }

        return $this->builder;
    }

    /**
     * Get filters from the request
     *
     * @return array
     */
    public function filters()
    {
        return $this->request;
    }

}
