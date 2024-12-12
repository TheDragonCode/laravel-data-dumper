<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Service;

use DragonCode\LaravelDataDumper\Schema\MySqlSchemaState;
use DragonCode\LaravelDataDumper\Schema\PostgresSchemaState;
use DragonCode\LaravelDataDumper\Schema\SQLiteSchemaState;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Connection;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\Schema\SchemaState;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Facades\Schema;

class Dumper
{
    public function dump(Connection $connection, string $path, array $tables): void
    {
        foreach ($tables as $table => $params) {
            if ($this->isNotMigration($table)) {
                $this->export($connection, $path, $table);

                if (is_array($params) && count($params) === 2) {
                    $this->deleteFiles($connection, $table, $params[0], $params[1]);
                }
            }
        }
    }

    protected function export(Connection $connection, string $path, string $table): void
    {
        $this->schemaState($connection)
            ?->withMigrationTable($table)
            ?->dump($connection, $path);
    }

    protected function deleteFiles(Connection $connection, string $table, string $column, string $path): void
    {
        $connection->table($table)->when(
            $this->hasIdColumn($connection, $table),
            fn (Builder $query) => $query->lazyById(),
            fn (Builder $query) => $query->lazyById(column: $column),
        )->each(
            fn ($item) => Files::delete($path, $item->{$column})
        );
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

    protected function hasIdColumn(Connection $connection, string $table): bool
    {
        return Schema::connection($connection->getName())->hasColumn($table, 'id');
    }
}
