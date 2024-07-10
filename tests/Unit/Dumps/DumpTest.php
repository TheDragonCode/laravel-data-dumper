<?php

use Illuminate\Database\Console\DumpCommand;
use Illuminate\Support\Facades\Artisan;

it('checks the export of data from tables to a dump file', function () {
    expect()
        ->toBeHasTables()
        ->toBeFilledTables();

    $path = dumpStoragePath();

    Artisan::call(DumpCommand::class, ['--path' => $path]);

    expect(file_get_contents($path))
        ->toBeContainsMigrations()
        ->toBeDataContains('foo')
        ->toBeDataContains('bar')
        ->toBeDataContains('articles')
        ->notToBeDataContains('baz');
})->group('SQLite', 'MySQL', 'Postgres');
