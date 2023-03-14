<?php

namespace Dmiknys\LaravelModelSieve\Interfaces;

use Illuminate\Database\Query\Builder;

interface Filter
{
    public function filter(Builder $builder, string $column, mixed $value): Builder;
}
