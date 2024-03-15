<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Service;

use Illuminate\Database\Connection;

class Dumper
{
    public function dump(Connection $connection, string $path, array $tables): void
    {
        foreach ($tables as $table) {
            $this->export($connection, $path, $table);
        }
    }

    protected function export(Connection $connection, string $path, string $table): void
    {
        // export table data to file
    }
}
