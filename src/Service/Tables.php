<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Tables
{
    public function dumpable(): array
    {
        return array_intersect($this->available(), $this->tables());
    }

    protected function tables(): array
    {
        return collect(config('database.schema.tables', []))
            ->map(fn (string $table) => $this->fromModels($table))
            ->all();
    }

    protected function available(): array
    {
        return array_column($this->tableSchema(), 'name');
    }

    protected function tableSchema(): array
    {
        return Schema::getTables();
    }

    protected function fromModels(Model|string $table): string
    {
        if (! class_exists($table)) {
            return $table;
        }

        return (new $table())->getTable();
    }
}
