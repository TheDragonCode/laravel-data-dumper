<?php

declare(strict_types=1);

expect()->extend('toBeDataContains', function () {
    foreach (allTableNames() as $table) {
        expect($this->value)
            ->toContain(tableName($table))
            ->toContain(columnName($table));

        circleProcess(
            fn (int $i) => expect($this->value)->toContain(valueName($table, $i))
        );
    }
});

expect()->extend('toBeContainsMigrations', function () {
    expect($this->value)
        ->toContain('2024_03_15_000001_foo')
        ->toContain('2024_03_15_000002_bar')
        ->toContain('2024_03_15_000003_baz');
});
