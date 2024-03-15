<?php

use Illuminate\Database\Console\DumpCommand;

use function Pest\Laravel\artisan;

test('checks an attempt to export the migration table from mysql', function () {
    $migrations = is_array($table = config('database.migrations')) ? $table['table'] : $table;

    config()->set('database.schema.tables', [$migrations]);

    $path = dumpStoragePath();

    artisan(DumpCommand::class, ['--path' => $path])->run();

    expect(file_get_contents($path))
        ->toBeContainsMigrations()
        ->toBeWordsCount("INSERT INTO `$migrations`", 3)
        ->notToBeDataContains('foo')
        ->notToBeDataContains('bar')
        ->notToBeDataContains('baz');
})->group('MySQL');
