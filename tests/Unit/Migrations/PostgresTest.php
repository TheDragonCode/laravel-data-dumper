<?php

declare(strict_types=1);

test('checks an attempt to export the migration table from postgres', function () {
    expect('COPY public.%s')->toBeDumped(1);
})->group('Postgres');
