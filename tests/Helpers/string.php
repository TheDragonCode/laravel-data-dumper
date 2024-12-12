<?php

declare(strict_types=1);

use Illuminate\Database\Console\DumpCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

use function PHPUnit\Framework\assertSame;

expect()->extend('toBeWordsCount', function (string $word, int $count) {
    assertSame($count, Str::substrCount($this->value, $word));

    return $this;
});

expect()->extend('toBeDumped', function (int $count) {
    $migrations = is_array($table = config('database.migrations')) ? $table['table'] : $table;

    config()->set('database.schema.tables', [$migrations]);

    $path = dumpStoragePath();

    Artisan::call(DumpCommand::class, ['--path' => $path]);

    expect(file_get_contents($path))
        ->toBeContainsMigrations()
        ->toBeWordsCount(sprintf($this->value, $migrations), $count)
        ->notToBeDataContains('foo')
        ->notToBeDataContains('bar')
        ->notToBeDataContains('baz')
        ->notToBeDataContains('qwerty1')
        ->notToBeDataContains('qwerty2');
});
