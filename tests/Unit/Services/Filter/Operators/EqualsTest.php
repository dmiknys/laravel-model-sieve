<?php

namespace Dmiknys\LaravelModelSieve\Tests\Unit\Services\Filter\Operators;

use Dmiknys\LaravelModelSieve\Services\Filter\Operators\Equals;
use Dmiknys\LaravelModelSieve\Tests\TestCase;
use Illuminate\Database\Query\Builder;

class EqualsTest extends TestCase
{
    private Equals $filter;

    protected function setUp(): void
    {
        $this->filter = new Equals();

        parent::setUp();
    }

    /** @test */
    public function shouldAttachEqualsClauseOnQueryBuilder(): void
    {
        $binding = 'value1';
        $column = 'column_name';

        $builder = $this->partialMock(Builder::class);
        $builder->shouldAllowMockingProtectedMethods();
        $builder->shouldReceive('isBitwiseOperator')->andReturnFalse();

        /** @var Builder $builder */
        $this->filter->filter($builder, $column, $binding);

        $this->assertSame([
            'type' => 'Basic',
            'column' => $column,
            'operator' => '=',
            'value' => $binding,
            'boolean' => 'and',
        ], $builder->wheres[0]);
    }
}