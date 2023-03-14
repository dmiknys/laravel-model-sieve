<?php

namespace Dmiknys\LaravelModelSieve\Providers;

use Dmiknys\LaravelModelSieve\Console\Commands\CreateFilterCommand;
use Dmiknys\LaravelModelSieve\Services\Filter\FilterContext;
use Dmiknys\LaravelModelSieve\Services\Filter\Operators\Between;
use Dmiknys\LaravelModelSieve\Services\Filter\Operators\Equals;
use Dmiknys\LaravelModelSieve\Services\Filter\Operators\In;
use Dmiknys\LaravelModelSieve\Services\Filter\Operators\Like;
use Illuminate\Support\ServiceProvider;

class SieveServiceProvider extends ServiceProvider
{
    public const TAG_FILTERS = 'filters';

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/config.php' => config_path('sieve.php'),
            ], 'config');

            $this->commands([
                CreateFilterCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php', 'sieve'
        );

        $this->app->tag(
            [
                ...config('sieve.custom_filters', []),
                ...[
                    In::class,
                    Equals::class,
                    Between::class,
                    Like::class,
                ],
            ],
            self::TAG_FILTERS
        );

        $this->app->bind(
            FilterContext::class,
            fn() => new FilterContext($this->app->tagged(self::TAG_FILTERS))
        );
    }
}
