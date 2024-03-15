<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Service;

use Illuminate\Support\Facades\Schema;

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
        return array_column($this->getTables(), 'name');
    }

    protected function getTables(): array
    {
        return Schema::getTables();
    }
}
