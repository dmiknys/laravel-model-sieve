<?php

namespace Dmiknys\LaravelModelSieve\Services;

use Dmiknys\LaravelModelSieve\Services\Filter\FilterContextException;
use Dmiknys\LaravelModelSieve\Services\Filter\FilterManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

final class SieveService
{
    public function __construct(
        private readonly FilterManager $filterManager
    ) {
    }

    /**
     * @throws Exception
     */
    public function applyQueryManipulationsFromRequest(Request $request, Builder $builder): Builder
    {
        [$filters, $order, $search] = $this->parseManipulations($request->all());

        $builder = $this->applyFilters($builder, $filters);
//        $builder = $this->applyOrder($builder, $order); // TODO: implement later
//        $builder = $this->applySearch($builder, $order); // TODO: implement later

        return $builder;
    }

    /**
     * @throws FilterContextException
     */
    public function applyFilters(Builder $builder, array $filters = []): Builder
    {
        return $this->filterManager->applyFilters($builder, $filters);
    }

    private function parseManipulations(array $params): array
    {
        $filters = [];
        $order = [];
        $search = null;

        foreach ($params as $key => $value) {
            switch (true) {
                case str_starts_with($key, config('query_filter_prefix', 'filter')):
                    $filters[] = [...explode('_', $key), $value];
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
