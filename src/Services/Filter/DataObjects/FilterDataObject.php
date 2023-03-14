<?php

namespace Dmiknys\LaravelModelSieve\Services\Filter\DataObjects;

use Illuminate\Support\Str;

class FilterDataObject
{
    public function __construct(
        private string $operator,
        private string $column,
        private mixed  $value,
    )
    {
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getColumn(): string
    {
        return Str::snake($this->column);
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}