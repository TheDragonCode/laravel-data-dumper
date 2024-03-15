<?php

declare(strict_types=1);

use Illuminate\Support\Facades\ParallelTesting;

function dumpStoragePath(): string
{
    return dumpPath('dump', 'sql');
}

function databasePath(): string
{
    return dumpPath('database', 'sqlite');
}

function dumpPath(string $name, string $extension): string
{
    $path = __DIR__ . '/../tmp/' . $name . '-' . processIndex() . '.' . $extension;

    if (!is_dir($directory = dirname($path))) {
        mkdir($directory);
    }

    return $path;
}

function processIndex(): int
{
    return (int)ParallelTesting::token();
}
