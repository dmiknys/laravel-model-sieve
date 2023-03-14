<?php

namespace Dmiknys\LaravelModelSieve\Services\Filter;

use Dmiknys\LaravelModelSieve\Interfaces\HasFilters;
use Dmiknys\LaravelModelSieve\Services\Filter\DataObjects\FilterDataObject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

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

        if (!$model instanceof HasFilters) {
            return $builder;
        }

        $allowedColumns = $this->getAllowedColumns($model, $builder);

        if (!in_array($filterDataObject->getColumn(), $allowedColumns, true)) {
            return $builder;
        }

        $filteredQuery = $this->filterContext
            ->getFilter($filterDataObject->getOperator())
            ->filter($builder->getQuery(), $filterDataObject->getColumn(), $filterDataObject->getValue());

        return $builder->setQuery($filteredQuery);
    }

    private function getAllowedColumns(HasFilters $model, Builder $builder): array
    {
        return $model->getFilterableColumns() === ['*']
            ? Schema::getColumnListing($builder->getModel()->getTable())
            : $model->getFilterableColumns();
    }
}
