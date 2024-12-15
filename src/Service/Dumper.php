<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Service;

use DragonCode\LaravelDataDumper\Schema\MySqlSchemaState;
use DragonCode\LaravelDataDumper\Schema\PostgresSchemaState;
use DragonCode\LaravelDataDumper\Schema\SQLiteSchemaState;
use Illuminate\Database\Connection;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\Schema\SchemaState;
use Illuminate\Database\SQLiteConnection;

class Dumper
{
    public function __construct(
        protected readonly Files $files
    ) {}

    public function dump(Connection $connection, string $path, array $tables): void
    {
        foreach (array_keys($tables) as $table) {
            if ($this->isNotMigration($table)) {
                $this->export($connection, $path, $table);
            }
        }
    }

    protected function export(Connection $connection, string $path, string $table): void
    {
        $this->schemaState($connection)
            ?->withMigrationTable($table)
            ?->dump($connection, $path);
    }

    protected function schemaState(Connection $connection): ?SchemaState
    {
        return match (get_class($connection)) {
            SQLiteConnection::class   => new SQLiteSchemaState($connection, null, null),
            MySqlConnection::class    => new MySqlSchemaState($connection, null, null),
            PostgresConnection::class => new PostgresSchemaState($connection, null, null),
            default                   => null
        };
    }

    protected function isNotMigration(string $table): bool
    {
        return $table !== $this->migrationTable();
    }

    protected function migrationTable(): string
    {
        return is_array($migration = config('database.migrations')) ? $migration['table'] : $migration;
    }
}
