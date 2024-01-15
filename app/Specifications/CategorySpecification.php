<?php

namespace App\Specifications;

class CategorySpecification implements Specifications
{
    protected int $categoryID;

    public function __construct(int $categoryID)
    {
        $this->categoryID = $categoryID;
    }

    public function toQuery($query)
    {
        return $query->where('category_id', $this->categoryID);
    }
}
