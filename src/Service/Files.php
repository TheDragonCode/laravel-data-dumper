<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Service;

use Closure;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Str;

class Files
{
    public function delete(string $path, string $filename): void
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

        return realpath(base_path($path));
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
}
