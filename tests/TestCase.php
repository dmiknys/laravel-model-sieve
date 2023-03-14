<?php

namespace Dmiknys\LaravelModelSieve\Tests;

use Dmiknys\LaravelModelSieve\Providers\SieveServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Foundation\Application;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Include the package's service provider(s)
     *
     * @see https://github.com/orchestral/testbench#custom-service-provider
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            SieveServiceProvider::class
        ];
    }
}
