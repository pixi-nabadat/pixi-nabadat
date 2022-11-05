<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class ProductsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }
}
