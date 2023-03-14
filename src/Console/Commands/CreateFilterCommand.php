<?php

namespace Dmiknys\LaravelModelSieve\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateFilterCommand extends GeneratorCommand
{
    protected $signature = 'make:filter';
    protected $description = 'Creates custom filter class';

    protected function getStub()
    {
        return '/../../../stubs/filter.stub';
    }
}
