<?php

use Illuminate\Database\Console\DumpCommand;

use function Pest\Laravel\artisan;

test('checks an attempt to export the migration table from sqlite', function () {
    $migrations = is_array($table = config('database.migrations')) ? $table['table'] : $table;

    config()->set('database.schema.tables', [$migrations]);

    $path = dumpStoragePath();

    artisan(DumpCommand::class, ['--path' => $path])->run();

    expect(file_get_contents($path))
        ->toBeContainsMigrations()
        ->toBeWordsCount($migrations, 4)
        ->notToBeDataContains('foo')
        ->notToBeDataContains('bar')
        ->notToBeDataContains('baz');
})->group('SQLite');
