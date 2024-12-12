<?php

test('checks an attempt to export the migration table from sqlite', function () {
    expect('INSERT INTO %s')->toBeDumped(6);
})->group('SQLite');
