<?php

test('checks an attempt to export the migration table from postgres', function () {
    expect('COPY public.%s')->toBeDumped(1);
})->group('Postgres');
