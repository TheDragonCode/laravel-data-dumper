<?php

declare(strict_types=1);

expect()->extend('toBeDataContains', function (string $name) {
    expect($this->value)
        ->toContain(tableName($name))
        ->toContain(columnName($name));

    circleProcess(
        fn (int $i) => expect($this->value)->toContain(valueName($name, $i))
    );
});

expect()->extend('notToBeDataContains', function (string $name) {
    expect($this->value)
        ->toContain(tableName($name))
        ->toContain(columnName($name));

    circleProcess(
        fn (int $i) => expect($this->value)->not->toContain(valueName($name, $i))
    );
});

expect()->extend('toBeContainsMigrations', function () {
    expect($this->value)
        ->toContain('2024_03_15_000001_foo')
        ->toContain('2024_03_15_000002_bar')
        ->toContain('2024_03_15_000003_baz');
});
