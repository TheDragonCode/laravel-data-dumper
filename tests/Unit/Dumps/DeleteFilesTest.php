<?php

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use Illuminate\Database\Console\DumpCommand;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

it('checks for file deletion on older versions of Laravel', function () {
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
})->group('SQLite', 'MySQL', 'Postgres')->skip(
    version_compare(Application::VERSION, '11.36.0', '>=')
);

it('checks for file deletion on new version of Laravel', function () {
    Directory::ensureDelete(base_path('to_delete'));

    circleProcess(fn (int $i) => File::store(base_path("to_delete/first/qwerty1File$i.stub"), '1'));
    circleProcess(fn (int $i) => File::store(base_path("to_delete/second/sub/qwerty2File$i.stub"), '1'));
    circleProcess(fn (int $i) => File::store(base_path("to_delete/third/file$i.stub"), '1'));

    Artisan::call(DumpCommand::class, ['--path' => dumpStoragePath(), '----prune' => true]);

    circleProcess(fn (int $i) => expect(
        file_exists(base_path("to_delete/first/qwerty1File$i.stub"))
    )->toBe($i % 2 === 0));

    circleProcess(fn (int $i) => expect(
        file_exists(base_path("to_delete/second/sub/qwerty2File$i.stub"))
    )->toBeFalse());

    circleProcess(fn (int $i) => expect(
        file_exists(base_path("to_delete/third/file$i.stub"))
    )->toBeTrue());
})->group('SQLite', 'MySQL', 'Postgres')->skip(
    version_compare(Application::VERSION, '11.36.0', '<')
);

it('checks for skipping file deletion on new version of Laravel', function () {
    Directory::ensureDelete(base_path('to_delete'));

    circleProcess(fn (int $i) => File::store(base_path("to_delete/first/qwerty1File$i.stub"), '1'));
    circleProcess(fn (int $i) => File::store(base_path("to_delete/second/sub/qwerty2File$i.stub"), '1'));
    circleProcess(fn (int $i) => File::store(base_path("to_delete/third/file$i.stub"), '1'));

    Artisan::call(DumpCommand::class, ['--path' => dumpStoragePath()]);

    circleProcess(fn (int $i) => expect(
        file_exists(base_path("to_delete/first/qwerty1File$i.stub"))
    )->toBeTrue());

    circleProcess(fn (int $i) => expect(
        file_exists(base_path("to_delete/second/sub/qwerty2File$i.stub"))
    )->toBeTrue());

    circleProcess(fn (int $i) => expect(
        file_exists(base_path("to_delete/third/file$i.stub"))
    )->toBeTrue());
})->group('SQLite', 'MySQL', 'Postgres')->skip(
    version_compare(Application::VERSION, '11.36.0', '<')
);
