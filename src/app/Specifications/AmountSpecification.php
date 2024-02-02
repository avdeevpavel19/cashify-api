<?php

namespace App\Specifications;

class AmountSpecification implements Specifications
{
    protected int $amount;

    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    public function toQuery($query)
    {
        return $query->where('amount', $this->amount);
    }
}
