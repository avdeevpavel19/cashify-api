<?php

namespace App\Filters;

interface Filter
{
    public function apply($query, $value);
}
