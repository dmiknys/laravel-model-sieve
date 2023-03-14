<?php

namespace Dmiknys\LaravelModelSieve\Interfaces;

interface HasFilters
{
    public function getFilterableColumns(): array;
}
