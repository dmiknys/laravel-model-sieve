<?php

namespace Dmiknys\LaravelModelSieve\Tests\Unit\Services;

use Dmiknys\LaravelModelSieve\Services\Filter\DataObjects\FilterDataObject;
use Dmiknys\LaravelModelSieve\Services\Filter\FilterManager;
use Dmiknys\LaravelModelSieve\Services\SieveService;
use Dmiknys\LaravelModelSieve\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SieveServiceTest extends TestCase
{
    private SieveService $service;

    protected function setUp(): void
    {
        parent::setUp();

    }

    /** @test */
    public function shouldApplyFiltersFromRequest(): void
    {
        $filters = [
            'filter_equals_userId' => 1,
            'filter_between_testColumn' => 'value,value2',
        ];

        $request = $this->partialMock(Request::class);
        $request->shouldReceive('all')->andReturn($filters);

        $builder = $this->partialMock(Builder::class);

        $this->partialMock(FilterManager::class)
            ->shouldReceive('applyFilter')
            ->times(count($filters))
        ;

        /** @var SieveService $service */
        $service = $this->app->make(SieveService::class);

        $service->applyFiltersFromRequest($request, $builder);
    }

    /** @test */
    public function shouldApplyManipulationsFromRequest(): void
    {
        $filters = [
            'filter_equals_userId' => 1,
            'sort_test' => 'desc',
            'search' => 'abc'
        ];

        $request = $this->partialMock(Request::class);
        $request->shouldReceive('all')->andReturn($filters);

        $builder = $this->partialMock(Builder::class);

        $this->partialMock(FilterManager::class)
            ->shouldReceive('applyFilter')
            ->once()
        ;

        /** @var SieveService $service */
        $service = $this->app->make(SieveService::class);

        $service->applyQueryManipulationsFromRequest($request, $builder);
    }

    /** @test */
    public function shouldApplyFilterToBuilderFromFilterDataObject(): void
    {
        $builder = $this->partialMock(Builder::class);
        $filterObject = new FilterDataObject('in', 'test', ['test', 'test2']);

        $this->partialMock(FilterManager::class)
            ->shouldReceive('applyFilter')
            ->with($builder, $filterObject)
            ->once()
        ;

        /** @var SieveService $service */
        $service = $this->app->make(SieveService::class);


        $service->applyFilter($builder, $filterObject);
    }
}