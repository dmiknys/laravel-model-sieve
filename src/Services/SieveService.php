<?php

namespace Dmiknys\LaravelModelSieve\Services;

use Dmiknys\LaravelModelSieve\Services\Filter\DataObjects\FilterDataObject;
use Dmiknys\LaravelModelSieve\Services\Filter\FilterContextException;
use Dmiknys\LaravelModelSieve\Services\Filter\FilterManager;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SieveService
{
    public function __construct(
        private readonly FilterManager $filterManager
    ) {
    }

    /**
     * @throws FilterContextException
     */
    public function applyQueryManipulationsFromRequest(Request $request, Builder $builder): Builder
    {
        [$filters, $order, $search] = $this->parseManipulations($request->all());

        /** @var FilterDataObject $filter */
        foreach ($filters as $filter) {
            $builder = $this->applyFilter($builder, $filter);
        }

//        $builder = $this->applyOrder($builder, $order); // TODO: implement later
//        $builder = $this->applySearch($builder, $order); // TODO: implement later

        return $builder;
    }

    /**
     * @throws FilterContextException
     */
    public function applyFiltersFromRequest(Request $request, Builder $builder): Builder
    {
        [$filters] = $this->parseManipulations($request->all());

        /** @var FilterDataObject $filter */
        foreach ($filters as $filter) {
            $this->applyFilter($builder, $filter);
        }

        return $builder;
    }

    /**
     * @throws FilterContextException
     */
    public function applyFilter(Builder $builder, FilterDataObject $filter): Builder
    {
        return $this->filterManager->applyFilter($builder, $filter);
    }

    private function parseManipulations(array $params): array
    {
        $filters = [];
        $order = [];
        $search = null;

        foreach ($params as $key => $value) {
            switch (true) {
                case str_starts_with($key, config('query_filter_prefix', 'filter')):
                    [,$operator, $column] = explode('_', $key);

                    $filters[] = new FilterDataObject($operator, $column, $value);
                    break;
                case str_starts_with($key, config('query_order_prefix', 'order')):
                    $order = [...explode('_', $key), $value];
                    break;
                case $key === config('query_search_parameter', 'search'):
                    $search = $value;
            }
        }

        return [$filters, $order, $search];
    }
}
