<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Listeners;

use DragonCode\LaravelDataDumper\Service\Dumper;
use DragonCode\LaravelDataDumper\Service\Tables;
use Illuminate\Database\Events\SchemaDumped;

class DataDumpListener
{
    public function __construct(
        protected readonly Tables $tables,
        protected readonly Dumper $dumper
    ) {
    }

    public function handle(SchemaDumped $event): void
    {
        $this->dumper->dump(
            $event->connection,
            $event->path,
            $this->tables->dumpable()
        );
    }
}
