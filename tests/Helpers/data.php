<?php

declare(strict_types=1);

expect()->extend('toBeDataContains', function (string $name, ?Closure $callback = null, ?Closure $not = null) {
    expect($this->value)
        ->toContain(tableName($name))
        ->toContain(columnName($name));

    $callback ??= fn (int $i) => valueName($name, $i);
    $not      ??= fn (int $i) => false;

    circleProcess(
        fn (int $i) => $not($i)
            ? expect($this->value)->not()->toContain($callback($i))
            : expect($this->value)->toContain($callback($i))
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
        ->toContain('2024_03_15_000003_baz')
        ->toContain('2024_07_10_222137_articles')
        ->toContain('2024_12_12_210937_qwerty1')
        ->toContain('2024_12_12_210949_qwerty2');
});
