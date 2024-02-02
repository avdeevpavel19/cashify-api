<?php

namespace App\Specifications;

use Illuminate\Support\Facades\Date;

class DateSpecification implements Specifications
{
    protected Date $date;

    public function __construct(Date $date)
    {
        $this->date = $date;
    }

    public function toQuery($query)
    {
        return $query->whereDate('date', $this->date);
    }
}
