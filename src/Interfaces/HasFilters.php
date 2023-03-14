<?php

namespace Dmiknys\LaravelModelSieve\Interfaces;

interface HasFilters
{
    /**
     * @return array<int, string>
     */
    public function getFilterableColumns(): array;
}
