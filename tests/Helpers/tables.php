<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;

expect()->extend('toBeHasTables', function () {
    $actual = array_column(Schema::getTables(), 'name');

    sort($actual);

    expect(array_values($actual))->toBe(
        array_values(allTableNames())
    );

    return $this;
});

function allTableNames(): array
{
    $tables = array_map(fn (string $name) => tableName($name), names());

    $names = array_merge($tables, ['migrations']);

    sort($names);

    return $names;
}
