<?php

test('checks an attempt to export the migration table from sqlite', function () {
    expect('INSERT INTO %s')->toBeDumped(3);
})->group('SQLite');
