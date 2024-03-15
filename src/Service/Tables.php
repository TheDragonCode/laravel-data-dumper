<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Service;

use stdClass;

class Tables
{
    public function dumpable(): array
    {
        return array_intersect($this->flatten(), $this->toDump());
    }

    protected function toDump(): array
    {
        return config('database.schema.tables', []);
    }

    protected function flatten(): array
    {
        return array_map(function (array | stdClass $item) {
            return is_array($item) ? $item['name'] : $item->name;
        }, $this->getTables());
    }

    protected function getTables(): array
    {
        return method_exists($this->schema(), 'getAllTables')
            ? $this->schema()->getAllTables()
            : $this->schema()->getTables();
    }

    protected function schema()
    {
        return app('db.schema');
    }
}
