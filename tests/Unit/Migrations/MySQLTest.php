<?php

declare(strict_types=1);

test('checks an attempt to export the migration table from mysql', function () {
    expect('INSERT INTO `%s`')->toBeDumped(6);
})->group('MySQL');
