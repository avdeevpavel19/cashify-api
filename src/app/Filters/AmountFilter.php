<?php

namespace App\Filters;

class AmountFilter implements Filter
{
    public function apply($query, $value)
    {
        $query->where('amount', $value);
    }
}
