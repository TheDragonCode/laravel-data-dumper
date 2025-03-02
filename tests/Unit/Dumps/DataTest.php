<?php

declare(strict_types=1);

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
        ->toBeDataContains('qwerty1', fn (int $i) => "qwerty1File$i.stub", fn (int $i) => $i % 2 === 0)
        ->toBeDataContains('qwerty2', fn (int $i) => "sub/qwerty2File$i")
        ->notToBeDataContains('baz');
})->group('SQLite', 'MySQL', 'Postgres');
