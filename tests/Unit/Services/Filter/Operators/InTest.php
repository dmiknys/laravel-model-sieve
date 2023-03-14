<?php

namespace Dmiknys\LaravelModelSieve\Tests\Unit\Services\Filter\Operators;

use Dmiknys\LaravelModelSieve\Services\Filter\Operators\In;
use Dmiknys\LaravelModelSieve\Tests\TestCase;
use Illuminate\Database\Query\Builder;

class InTest extends TestCase
{
    private In $filter;

    protected function setUp(): void
    {
        $this->filter = new In();

        parent::setUp();
    }

    /** @test */
    public function shouldAttachInClauseOnQueryBuilder(): void
    {
        $bindings = ['value1', 'value2'];
        $column = 'column_name';

        /** @var Builder $builder */
        $builder = $this->partialMock(Builder::class);

        $this->filter->filter($builder, $column, $bindings);

        $this->assertSame([
            'type' => 'In',
            'column' => $column,
            'values' => $bindings,
            'boolean' => 'and'
        ], $builder->wheres[0]);
    }
}