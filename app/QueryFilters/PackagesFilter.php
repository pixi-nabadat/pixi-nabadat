<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;

class PackagesFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }
}
