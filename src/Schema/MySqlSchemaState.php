<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Schema;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\MySqlSchemaState as BaseSchemaState;

class MySqlSchemaState extends BaseSchemaState
{
    public function dump(Connection $connection, $path): void
    {
        $this->appendMigrationData($path);
    }
}
