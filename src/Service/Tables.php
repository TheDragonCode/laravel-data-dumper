<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Tables
{
    public function dumpable(): array
    {
        return collect($this->tables())
            ->intersectByKeys(collect($this->available())->flip())
            ->all();
    }

    protected function tables(): array
    {
        return collect(config('database.schema.tables'))
            ->mapWithKeys(function (array|string $value, int|string $key) {
                if (is_numeric($key)) {
                    $value = is_string($value) && ! is_numeric($value) ? $value : null;

                    return [$this->fromModels($value) => null];
                }

                if (is_string($key) && is_array($value)) {
                    return [$this->fromModels($key) => $value];
                }

                return [null => null];
            })->reject(
                fn (mixed $value, ?string $key) => is_null($key)
            )->all();
    }

    protected function available(): array
    {
        return array_column($this->tableSchema(), 'name');
    }

    protected function tableSchema(): array
    {
        return Schema::getTables();
    }

    protected function fromModels(Model|string|null $table): ?string
    {
        if (empty($table)) {
            return null;
        }

        if (! class_exists($table)) {
            return $table;
        }

        return (new $table())->getTable();
    }
}
