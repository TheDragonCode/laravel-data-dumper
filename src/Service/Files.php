<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Service;

use Closure;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Schema;

class Files
{
    public function clean(Connection $connection, array $tables): void
    {
        foreach ($tables as $table => $params) {
            if (is_array($params) && count($params) === 2) {
                $this->deleteFiles($connection, $table, $params[0], $params[1]);
            }
        }
    }

    protected function deleteFiles(Connection $connection, string $table, string $column, string $path): void
    {
        $connection->table($table)->when(
            $this->hasIdColumn($connection, $table),
            fn (Builder $query) => $query->lazyById(),
            fn (Builder $query) => $query->lazyById(column: $column),
        )->each(
            fn ($item) => $this->delete($path, $item->{$column})
        );
    }

    protected function delete(string $path, string $filename): void
    {
        if (! $dir = $this->directory($path)) {
            return;
        }

        if (! file_exists($dir . '/' . $filename)) {
            $filename = $this->findFile($dir, $filename);
        }

        File::ensureDelete($dir . '/' . $filename);
    }

    protected function directory(string $path): false|string
    {
        if (realpath($path) && is_dir($path)) {
            return rtrim($path, '\\/');
        }

        if (is_dir($path = realpath(base_path($path)))) {
            return rtrim($path, '\\/');
        }

        return false;
    }

    protected function findFile(string $path, string $filename): string
    {
        return $this->find($path, function (string $name) use ($filename) {
            return Str::contains($this->resolvePath($name), $this->resolvePath($filename));
        }) ?? $filename;
    }

    protected function find(string $path, Closure $when): ?string
    {
        return File::names($path, $when, true)[0] ?? null;
    }

    protected function resolvePath(string $path): string
    {
        return str_replace('\\', '/', $path);
    }

    protected function hasIdColumn(Connection $connection, string $table): bool
    {
        return Schema::connection($connection->getName())->hasColumn($table, 'id');
    }
}
