<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Schema;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\SqliteSchemaState as BaseSchemaState;

class SQLiteSchemaState extends BaseSchemaState
{
    public function dump(Connection $connection, $path): void
    {
        $this->appendMigrationData($path);
    }
}
