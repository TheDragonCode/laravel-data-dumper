<?php

use Illuminate\Database\Console\DumpCommand;

use function Pest\Laravel\artisan;

test('checks an attempt to export the migration table from postgres', function () {
    $migrations = is_array($table = config('database.migrations')) ? $table['table'] : $table;

    config()->set('database.schema.tables', [$migrations]);

    $path = dumpStoragePath();

    artisan(DumpCommand::class, ['--path' => $path])->run();

    expect(file_get_contents($path))
        ->toBeContainsMigrations()
        ->toBeWordsCount("COPY public.$migrations", 1)
        ->notToBeDataContains('foo')
        ->notToBeDataContains('bar')
        ->notToBeDataContains('baz');
})->group('Postgres');
