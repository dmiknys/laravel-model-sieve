<?php

namespace Dmiknys\LaravelModelSieve\Services\Filter;

use Dmiknys\LaravelModelSieve\Interfaces\HasFilters;
use Dmiknys\LaravelModelSieve\Services\Filter\DataObjects\FilterDataObject;
use Illuminate\Database\Eloquent\Builder;

class FilterManager
{
    public function __construct(
        private readonly FilterContext $filterContext
    )
    {
    }

    /**
     * @throws FilterContextException
     */
    public function applyFilter(Builder $builder, FilterDataObject $filterDataObject): Builder
    {
        $model = $builder->getModel();

        if (
            !$model instanceof HasFilters
            || !in_array($filterDataObject->getColumn(), $model->getFilterableColumns(), true)
        ) {
            return $builder;
        }

        $filteredQuery = $this->filterContext
            ->getFilter($filterDataObject->getOperator())
            ->filter($builder->getQuery(), $filterDataObject->getColumn(), $filterDataObject->getValue());

        return $builder->setQuery($filteredQuery);
    }
}
