<?php

namespace Dmiknys\LaravelModelSieve\Tests\Unit\Services\Filter;

use Dmiknys\LaravelModelSieve\Services\Filter\FilterContext;
use Dmiknys\LaravelModelSieve\Services\Filter\FilterContextException;
use Dmiknys\LaravelModelSieve\Services\Filter\Operators\Between;
use Dmiknys\LaravelModelSieve\Tests\TestCase;

class FilterContextTest extends TestCase
{
    private FilterContext $context;

    protected function setUp(): void
    {
        parent::setUp();

        $this->context = $this->app->make(FilterContext::class);
    }

    /** @test */
    public function shouldThrowExceptionIfFilterIsNotListedInCustomList(): void
    {
        $this->expectException(FilterContextException::class);

        $this->context->getFilter('non-existent');

        $this->fail();
    }

    /**
     * @test
     * @throws FilterContextException
     */
    public function shouldFetchFilterBasedOnClassNameByGivenQueryParam(): void
    {
        $filter = $this->context->getFilter('between');

        $this->assertInstanceOf(Between::class, $filter);
    }
}