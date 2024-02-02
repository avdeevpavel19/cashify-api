<?php

namespace App\Filters;

class CategoryFilter implements Filter
{
    public function apply($query, $value)
    {
        $query->where('category_id', $value);
    }
}
