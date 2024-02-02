<?php

namespace App\Filters;

use Illuminate\Http\Request;

class TransactionFilter
{
    protected       $query;
    protected array $filters = [
        'amount'      => AmountFilter::class,
        'category_id' => CategoryFilter::class,
        'date'        => DateFilter::class,
    ];

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function apply(Request $request)
    {
        foreach ($this->filters as $key => $filter) {
            if ($request->has($key)) {
                $filter = new $filter;
                $filter->apply($this->query, $request->input($key));
            }
        }

        return $this->query;
    }
}
