<?php

namespace Dmiknys\LaravelModelSieve\Services\Filter\Operators;

use Dmiknys\LaravelModelSieve\Interfaces\Filter;
use Illuminate\Database\Query\Builder;

class In implements Filter
{
    public function filter(Builder $builder, string $column, mixed $value): Builder
    {
        return $builder->whereIn($column, $value);
    }
}
