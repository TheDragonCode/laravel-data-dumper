<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Service;

use DragonCode\Support\Facades\Filesystem\File;

class Files
{
    public static function delete(string $path, string $filename): void
    {
        if (! $dir = static::directory($path)) {
            return;
        }

        File::ensureDelete($dir . '/' . $filename);
    }

    protected static function directory(string $path): false|string
    {
        if (realpath($path) && is_dir($path)) {
            return rtrim($path, '\\/');
        }

        return realpath(base_path($path));
    }
}
