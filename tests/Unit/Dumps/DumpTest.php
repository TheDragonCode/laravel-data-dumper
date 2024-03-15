<?php

use Illuminate\Database\Console\DumpCommand;

use function Pest\Laravel\artisan;

it('checks the export of data from tables to a dump file', function () {
    expect()
        ->toBeHasTables()
        ->toBeFilledTables();

    $path = dumpStoragePath();

    artisan(DumpCommand::class, ['--path' => $path])->run();

    expect(file_get_contents($path))
        ->toBeContainsMigrations()
        ->toBeDataContains('foo')
        ->toBeDataContains('bar')
        ->notToBeDataContains('baz');
})->group('SQLite', 'MySQL', 'Postgres');
