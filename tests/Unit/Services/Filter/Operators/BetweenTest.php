<?php

namespace Dmiknys\LaravelModelSieve\Tests\Unit\Services\Filter\Operators;

use Dmiknys\LaravelModelSieve\Services\Filter\Operators\Between;
use Dmiknys\LaravelModelSieve\Tests\TestCase;
use Illuminate\Database\Query\Builder;

class BetweenTest extends TestCase
{
    private Between $filter;

    protected function setUp(): void
    {
        $this->filter = new Between();

        parent::setUp();
    }

    /** @test */
    public function shouldAttachBetweenClauseOnQueryBuilder(): void
    {
        $bindings = ['value1', 'value2'];
        $column = 'column_name';

        /** @var Builder $builder */
        $builder = $this->partialMock(Builder::class);

        $this->filter->filter($builder, $column, $bindings);

        $this->assertSame([
            'type' => 'between',
            'column' => $column,
            'values' => $bindings,
            'boolean' => 'and',
            'not' => false
        ], $builder->wheres[0]);
    }
}