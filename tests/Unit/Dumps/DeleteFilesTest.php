<?php

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use Illuminate\Database\Console\DumpCommand;
use Illuminate\Support\Facades\Artisan;

it('checks the export of data from tables to a dump file', function () {
    Directory::ensureDelete(base_path('to_delete'));

    circleProcess(fn (int $i) => File::store(base_path("to_delete/first/qwerty1File$i.stub"), '1'));
    circleProcess(fn (int $i) => File::store(base_path("to_delete/second/sub/qwerty2File$i.stub"), '1'));
    circleProcess(fn (int $i) => File::store(base_path("to_delete/third/file$i.stub"), '1'));

    Artisan::call(DumpCommand::class, ['--path' => dumpStoragePath()]);

    circleProcess(fn (int $i) => expect(
        file_exists(base_path("to_delete/first/qwerty1File$i.stub"))
    )->toBe($i % 2 === 0));

    circleProcess(fn (int $i) => expect(
        file_exists(base_path("to_delete/second/sub/qwerty2File$i.stub"))
    )->toBeFalse());

    circleProcess(fn (int $i) => expect(
        file_exists(base_path("to_delete/third/file$i.stub"))
    )->toBeTrue());
})->group('SQLite', 'MySQL', 'Postgres');
