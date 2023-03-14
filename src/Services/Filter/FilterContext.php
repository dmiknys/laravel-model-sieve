<?php

namespace Dmiknys\LaravelModelSieve\Services\Filter;

use Dmiknys\LaravelModelSieve\Interfaces\Filter;
use Illuminate\Support\Str;

class FilterContext
{
    /** @var iterable<Filter> $filters */
    private iterable $filters;

    /** @param iterable<Filter> $filters */
    public function __construct(iterable $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @throws FilterContextException
     */
    public function getFilter(string $key): Filter
    {
        foreach ($this->filters as $filter) {
            assert($filter instanceof Filter);

            if (class_basename($filter) === Str::studly($key)) {
                return $filter;
            }
        }

        throw new FilterContextException("Filter '$key' does not exist or is not registered");
    }
}
