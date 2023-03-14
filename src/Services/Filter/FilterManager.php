<?php

namespace Dmiknys\LaravelModelSieve\Services\Filter;

use Dmiknys\LaravelModelSieve\Interfaces\HasFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class FilterManager
{
    public function __construct(
        private readonly FilterContext $filterContext
    ) {
    }

    /**
     * @throws FilterContextException
     */
    public function applyFilters(Builder $builder, array $queryParams): Builder
    {
        $model = $builder->getModel();

        if (!$model instanceof HasFilters || empty($queryParams)) {
            return $builder;
        }

        $queryBuilder = $builder->getQuery();

        foreach ($queryParams as $filter) {
            [,$type, $column, $value] = $filter;
            $column = Str::snake($column);

            if (!in_array($column, $model->getFilterableColumns(), true)) {
                continue;
            }

            $this->filterContext->getFilter($type)->filter($queryBuilder, $column, $value);
        }

        return $builder->setQuery($queryBuilder);
    }
}
