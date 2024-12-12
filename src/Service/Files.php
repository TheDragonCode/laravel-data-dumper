<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Service;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Str;

class Files
{
    public static function delete(string $path, string $filename): void
    {
        if (! $dir = static::directory($path)) {
            return;
        }

        if (! file_exists($dir . '/' . $filename)) {
            $filename = static::findFile($dir, $filename);
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

    protected static function findFile(string $path, string $filename): string
    {
        return File::names(
            $path,
            fn (string $name) => Str::contains(
                str_replace('\\', '/', $name),
                str_replace('\\', '/', $filename)
            ),
            recursive: true
        )[0];
    }
}
