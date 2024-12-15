<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Listeners;

use DragonCode\LaravelDataDumper\Service\Files;
use DragonCode\LaravelDataDumper\Service\Tables;
use Illuminate\Database\Events\MigrationsPruned;
use Illuminate\Database\Events\SchemaDumped;

class FilesListener extends Listener
{
    public function __construct(
        protected readonly Tables $tables,
        protected readonly Files $files
    ) {}

    public function handle(MigrationsPruned|SchemaDumped $event): void
    {
        $this->files->clean(
            $event->connection,
            $this->tables->dumpable()
        );
    }
}
