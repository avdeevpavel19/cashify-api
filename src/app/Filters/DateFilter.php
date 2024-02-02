<?php

namespace App\Filters;

class DateFilter implements Filter
{
    public function apply($query, $value)
    {
        $query->whereDate('date', $value);
    }
}
