<?php

declare(strict_types=1);

function dumpStoragePath(): string
{
    return dumpPath('dump.sql');
}

function databasePath(): string
{
    return dumpPath('database.sqlite');
}

function dumpPath(string $name): string
{
    $path = __DIR__ . '/../tmp/' . $name;

    if (!is_dir($directory = dirname($path))) {
        mkdir($directory);
    }

    return $path;
}
