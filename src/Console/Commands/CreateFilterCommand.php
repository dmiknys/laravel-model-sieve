<?php

namespace Dmiknys\LaravelModelSieve\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateFilterCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates custom filter class';


    public function handle(): int
    {
        return 0;
    }

    protected function getStub()
    {
        // TODO: Implement getStub() method.
    }
}
