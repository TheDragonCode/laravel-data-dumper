<?php

test('checks an attempt to export the migration table from mysql', function () {
    expect('INSERT INTO `%s`')->toBeDumped(4);
})->group('MySQL');
