<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Schema;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\PostgresSchemaState as BaseSchemaState;

class PostgresSchemaState extends BaseSchemaState
{
    public function dump(Connection $connection, $path): void
    {
        $commands = collect([
            $this->baseDumpCommand() . ' -t ' . $this->migrationTable . ' --data-only >> ' . $path,
        ]);

        $commands->map(function ($command, $path) {
            $this->makeProcess($command)->mustRun($this->output, $this->variables($path));
        });
    }

    protected function variables(string $path): array
    {
        return array_merge($this->baseVariables($this->connection->getConfig()), [
            'LARAVEL_LOAD_PATH' => $path,
        ]);
    }
}
